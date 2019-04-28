<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use function GuzzleHttp\json_decode;

class WxController extends Controller{
    public function valid(){
        echo $_GET['echostr'];
    }
    public function index(){
        //接收推送事件
        $content=file_get_contents("php://input");
        $time=date('Y-m-d H:i:s');
        $str=$time.$content."\n";
        file_put_contents("logs/wx_event.log",$str,FILE_APPEND);
        $data=simplexml_load_string($content);
        // print_r($data);die;
        $openid=$data->FromUserName;
        $wx_id=$data->ToUserName;
        $event = $data->Event;
        $MsgType=$data->MsgType;
        $content=$data->Content;
        $MediaId=$data->MediaId;
        $EventKey=$data->EventKey;
        // echo $EventKey;
        $u=$this->getUserInfo($openid);
        // dd($u);
        $access_token=getaccesstoken();
        if($event=="SCAN"){
            // echo "11";
            $info=[
                'openid'=>$openid,
                'nickname'=>$u['nickname'],
                'eventkey'=>$EventKey

            ];
            // dd($info);
            // $arr=DB::table('wx_user_code')->insert($info);
            $name="欢迎回来";
            $desc="我也不知道";
            $url="http://www.baidu.com";
            echo '<xml>
                <ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>1</ArticleCount>
                <Articles>
                  <item>
                    <Title><![CDATA['.$name.']]></Title>
                    <Description><![CDATA['.$desc.']]></Description>
                    <PicUrl><![CDATA['.'https://t1.huanqiu.cn/d488227386acf540fb202c1a6fa22059.jpeg'.']]></PicUrl>
                    <Url><![CDATA['.$url.']]></Url>
                  </item>
                </Articles>
              </xml>';

        }
        //获取素材
        if($MsgType=="text"){
            if(strpos($content,'+天气')){
                $city=explode('+',$content)[0];
                // echo "$city";
                $url="https://free-api.heweather.net/s6/weather/now?key=HE1904161049361666&location=$city";
                // echo $url;die;
                $arr=json_decode(file_get_contents($url),true);
                // print_r($arr);
                if($arr['HeWeather6'][0]['status']=="unknown location"){
                    echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
                    <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                    <CreateTime>'.time().'</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content>['.'城市名称不正确'.']</Content>
                    </xml>
                    ';
                }else{
                    $tmp=$arr['HeWeather6'][0]['now']['tmp'];//温度
                    $cond_txt=$arr['HeWeather6'][0]['now']['cond_txt'];//fen'li
                    $wind_sc=$arr['HeWeather6'][0]['now']['wind_sc'];//风力
                    $hum=$arr['HeWeather6'][0]['now']['hum']; // 湿度
                    $wind_dir=$arr['HeWeather6'][0]['now']['wind_dir'];// 风向
                    $res="$cond_txt 温度:$tmp 风力:$wind_sc 湿度:$hum 风向:$wind_dir";
                    echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
                    <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                    <CreateTime>'.time().'</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content>['.$res.']</Content>
                    </xml>
                    ';
                }
            }
            $text="还有什么可以帮助你的吗";
            $info=[
                    'openid'=>$openid,
                    'm_name'=>$u['nickname'],
                    'm_text'=> $content
            ];
            $arr=DB::table('userrecord')->insert($info);
            echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
               <Content>![CDATA['.$text.']</Content>
                </xml>
                ';
        }
        //获取图片
        if($MsgType=="image"){
            $access_token=getaccesstoken();
            $url="https://api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$MediaId";
            $imgtime=date('Y-m-d H:i:s');
            $image=file_get_contents($url);
            // dd($image);
            file_put_contents("/wwwroot/project/public/img/$imgtime.jpg",$image,FILE_APPEND);
        }
        //判断扫码
        if($event=='subscribe'){
            $user_info=DB::table('userwx')->where(['openid'=>$openid])->first();
            if($user_info){
                $res=DB::table('userwx')->where(['openid'=>$openid])->update(['is_server'=>1]);
            //     echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
            //     <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
            //     <CreateTime>'.time().'</CreateTime>
            //     <MsgType><![CDATA[text]]></MsgType>
            //    <Content>![CDATA['.'欢迎回来'.$user_info->nickname.']]</Content>
            //     </xml>
            //     ';
                $name="最新商品";
                $desc="aaa";
                $url="http://www.baidu.com";
                echo '<xml>
                    <ToUserName><![CDATA['.$openid.']]></ToUserName>
                    <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                    <CreateTime>'.time().'</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <ArticleCount>1</ArticleCount>
                    <Articles>
                      <item>
                        <Title><![CDATA['.$name.']]></Title>
                        <Description><![CDATA['.$desc.']]></Description>
                        <PicUrl><![CDATA['.'https://t1.huanqiu.cn/d488227386acf540fb202c1a6fa22059.jpeg'.']]></PicUrl>
                        <Url><![CDATA['.$url.']]></Url>
                      </item>
                    </Articles>
                  </xml>';
            }else{
                $u=$this->getUserInfo($openid);
                $info=[
                        'openid'=>$openid,
                        'nickname'=>$u['nickname'],
                        'sex'=>$u['sex'],
                        'headimgurl'=>$u['headimgurl'],
                        'subscribe_time'=>$u['subscribe_time'],
                ];
                // dd($info);
                $arr=DB::table('userwx')->insert($info);
                echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
               <Content>![CDATA['.'欢迎关注'.$u['nickname'].']]</Content>
                </xml>
                ';
            }
        }else if($event=="unsubscribe"){
            // echo "取关";
            $res=DB::table('userwx')->where(['openid'=>$openid])->update(['is_server'=>2]);
            // echo $res;die;
        }

    }
    /**用户信息 */
    public function getUserInfo($openid){
        $access_token=getaccesstoken();
        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
        // dd($url);
        $data=file_get_contents($url);
        $u=json_decode($data,true);
        return $u;
    }
}


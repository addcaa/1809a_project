<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class WxController extends Controller{
    public function valid(){
        echo $_GET['echostr'];
    }
    public function index(){
        $content=file_get_contents("php://input");
        $time=date('Y-m-d H:i:s');
        $str=$time.$content."\n";
        file_put_contents("logs/wx_event.log",$str,FILE_APPEND);
        $data=simplexml_load_string($content);
        // print_r($data);die;
        $openid=$data->FromUserName;
        $wx_id=$data->ToUserName;
        $event = $data->Event;
        if($event=='subscribe'){
            $user_info=DB::table('userwx')->where(['openid'=>$openid])->first();
            if($user_info){
                $res=DB::table('userwx')->where(['openid'=>$openid])->update(['is_server'=>1]);
                echo '<xml><ToUserName><![CDATA['.$openid.']]></ToUserName>
                <FromUserName><![CDATA['.$wx_id.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
               <Content>![CDATA['.'欢迎回来'.$user_info->nickname.']]</Content>
                </xml>
                ';
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

<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
class MenuController extends Controller{
    //**创建自定义菜单 */
    public function menu(){
        $access_token=getaccesstoken();
        // dd($access_token);
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $surl="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf6459da873fa2ef5&redirect_uri=http://1809cuifangfang.comcto.com/jssdk/getu&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        $sign="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf6459da873fa2ef5&redirect_uri=http://1809cuifangfang.comcto.com/menu/sign&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        $msg=[
            "button"=>[
               [
                    "type"=>"view",
                    "name"=>"最新福利",
                    "url"=>$surl
                ],
                [
                    "type"=>"view",
                    "name"=>"点击签到",
                    "url"=>$sign
                ],
            ],
        ];
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $client = new Client();
        $r = $client->request('POST', $url, [
            'body' =>$data
        ]);
        $obj=$r->getBody();
        $arr=json_decode($obj,true);
        dd($arr);
    }
    /**签到功能 */
    public function sign(){
        $code=$_GET['code'];
        //通过code换取网页授权access_token
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf6459da873fa2ef5&secret=84c923c15aa4e05ca40d3c59a135630f&code=$code&grant_type=authorization_code";
        $pesponse=json_decode(file_get_contents($url),true);
        $access_token=$pesponse['access_token'];
        $openid=$pesponse['openid'];
        //拉取用户信息(需scope为 snsapi_userinfo)
        $access_info="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $user=json_decode(file_get_contents($access_info),true);
        $openid=$user['openid'];
        $name=$user['nickname'];
        $time=time();
        $arr=date('Y-d-m H:i:s');
        // $arr=json_encode($info,JSON_UNESCAPED_UNICODE);
        $key="sign";
        Redis::lpush($key,$arr);
        $ser=Redis::lrange($key,0,-1);
        // $ser=json_decode(Redis::get($key),true);
        // dd($ser);
        var_dump($ser);die;
    }
}

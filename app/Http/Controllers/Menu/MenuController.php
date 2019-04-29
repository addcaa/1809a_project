<?php

namespace App\Http\Controllers\Menu;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use GuzzleHttp\Client;
class MenuController extends Controller{
    //**创建自定义菜单 */
    public function menu(){
        $access_token=getaccesstoken();
        // dd($access_token);
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $surl="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf6459da873fa2ef5&redirect_uri=http://1809cuifangfang.comcto.com/jssdk/getu&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        $sign="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf0e81c3bee622d60&redirect_uri=http://1809cuifangfang.comcto.com/menu/sign&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
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
        dd($_GET['code']);
    }
}

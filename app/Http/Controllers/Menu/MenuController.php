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
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
        $surl="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf6459da873fa2ef5&redirect_uri=http://1809cuifangfang.comcto.com/Menu/accredit&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        $msg=[
            "button"=>[
               [
                    "type"=>"view",
                    "name"=>"最新福利",
                    "url"=>$surl
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
    /**授权页面 */
    public function accredit(){
        dd($_GET['code']);
        $content=file_get_contents("php://input");
        $data=simplexml_load_string($content);
        // echo $data;die;
        $openid=$data->FromUserName;
        // echo $openid;die;
        $access_token='https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf6459da873fa2ef5&secret=84c923c15aa4e05ca40d3c59a135630f&code=CODE&grant_type=authorization_code';
        $url="https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";
        $r=json_decode(file_get_contents($url),true);
        dd($r);
    }
}

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
        $msg=[
            "button"=>[
                [
                    "type"=>"click",
                    "name"=>"今日歌曲",
                    "key"=>"V1001_TODAY_MUSIC"
                ],
                [
                    "name"=>"菜单",
                    "sub_button"=>[
                    [
                        "type"=>"view",
                        "name"=>"搜索",
                        "url"=>"http://www.soso.com/"
                    ],
                    [
                        "type"=>"miniprogram",
                        "name"=>"wxa",
                        "url"=>"http://mp.weixin.qq.com",
                        "appid"=>"wx286b93c14bbf93aa",
                        "pagepath"=>"pages/lunar/index"
                    ],
                    [
                        "type"=>"click",
                        "name"=>"赞一下我们",
                        "key"=>"V1001_GOOD"
                    ]]
                ],
                [
                    "name"=> "发图",
                    "sub_button"=> [
                        [
                            "type"=> "pic_sysphoto",
                            "name"=> "系统拍照发图",
                            "key"=> "rselfmenu_1_0",
                            "sub_button"=> [ ]
                        ],
                        [
                            "type"=> "pic_photo_or_album",
                            "name"=> "拍照或者相册发图",
                            "key"=> "rselfmenu_1_1",
                            "sub_button"=> [ ]
                        ],
                        [
                            "type"=> "pic_weixin",
                            "name"=> "微信相册发图",
                            "key"=> "rselfmenu_1_2",
                            "sub_button"=> [ ]
                        ]
                    ],
                ]
            ]
        ];
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $client = new Client();
        $r = $client->request('POST', $url, [
            'body' =>$data
        ]);
        $obj=$r->getBody();
        $arr=json_decode($obj,true);
    }
}

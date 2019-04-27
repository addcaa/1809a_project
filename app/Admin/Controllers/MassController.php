<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Client;
class MassController extends Controller{
    public function list(Content $Content){
        // return view('/mass/list');
        $user=DB::table('userwx')->get();
        return $Content ->header('群发')->body(view('admin.mass.list',['user'=>$user]));
    }
    public function addo(){
        $openid=$_POST['openid'];
        $openid=explode(',',$openid);
        $text=$_POST['text'];
        // dd($openid);
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$access_token";
        $msg=[
            "touser"=>$openid,
            "msgtype"=>"text",
            'text'=>[
                'content'=>$text
            ],
        ];
        // dd($msg);
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // dd($data);
        //  print_r($openid_arr);die;
        $client= new Client();
        $response=$client->request('post',$url,[
            'body'=>$data,
        ]);
        $obj=$response->getBody();
        $arr=json_decode($obj,true);
        echo "success";
    }
    /**添加标签 */
    public function label(Content $Content){
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=$access_token";
        $msg=[
            "tag"=>[
                "name"=>"广东"   //标签名
            ],
        ];
        // dd($msg);
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $client= new Client();
        $response = $client->request('POST',$url, [
            'body' => $data
        ]);
        $obj=$response->getBody();
        $arr=json_decode($obj,true);
        echo "success";
    }

}
?>

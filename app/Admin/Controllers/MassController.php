<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_decode;

class MassController extends Controller{
    public function list(Content $Content){
        // return view('/mass/list');
        $user=DB::table('userwx')->get();
        return $Content ->header('群发')->body(view('admin.mass.list',['user'=>$user]));
    }
    public function addo(){
        $openid=$_POST['openid'];
        $text=$_POST['text'];
        $msg=[
            "touser"=>$openid,
            "msgtype"=>"text",
            "text"=>$text
        ];
        // dd($openid,$text);
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$access_token";
        $arr=json_decode(file_get_contents($url),true);
        //  print_r($openid_arr);die;
        $response=$this->sendmse($openid,$msg);
        echo $response;
    }
}
?>

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
use function GuzzleHttp\json_encode;

class MassController extends Controller{
    public function list(Content $Content){
        // return view('/mass/list');
        $user=DB::table('userwx')->get();
        return $Content ->header('群发')->body(view('admin.mass.list',['user'=>$user]));
    }
    /** openid群发 */
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
        if(!empty($_GET)){
            if(empty($_GET['name'])){
                // return ['font'=>''];
                echo "标签不能为空";die;
            }else{
                $name=$_GET['name'];
                $access_token=getaccesstoken();
                $url="https://api.weixin.qq.com/cgi-bin/tags/create?access_token=$access_token";
                $msg=[
                    "tag"=>[
                        "name"=>$name   //标签名
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
                if($arr){
                    return ['font'=>'添加成功'];
                }else{
                    return ['font'=>'添加失败'];
                }
            }
        }
        return $Content ->header('添加标签')->body(view('admin.mass.label'));


    }
    /** 获取公众号已创建的标签 */
    public function thelabel(Content $Content){
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$access_token";
        $response=json_decode(file_get_contents($url),JSON_UNESCAPED_UNICODE);
        // dd($response);
        $arr=$response['tags'];
        return $Content ->header('获取公众号已创建的标签')->body(view('admin.mass.thelabel',['arr'=>$arr]));
    }
    /**批量为用户打标签 展示*/
    public function make(Content $Content){
        $user=DB::table('userwx')->get();
        //获取标签
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$access_token";
        $response=json_decode(file_get_contents($url),JSON_UNESCAPED_UNICODE);
        $arr=$response['tags'];

        return $Content ->header('获取公众号已创建的标签')->body(view('admin.mass.make',['user'=>$user,'arr'=>$arr]));
        // echo "success";
    }
    public function makeadd(){
        $label=$_POST['label'];
        $openid=explode(',',$_POST['openid']);
        // dd($openid,$label);
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=$access_token";
        $msg=[
                "openid_list" => $openid,
                "tagid"=>$label
        ];
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        $client=new Client();
        $response = $client->request('POST', $url, [
            'body' =>$data
        ]);
        $obj=$response->getBody();
        $arr=json_decode($obj,true);
        if($arr['errmsg']=="ok"){
            return ['font'=>"设置成功"];
        }else{
            return ['font'=>"设置失败"];
        }
    }
    /**标签群发 */
    public function thelabelmass(Content $Content){
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=$access_token";
        $response=json_decode(file_get_contents($url),JSON_UNESCAPED_UNICODE);
        // dd($response);
        $arr=$response['tags'];
        return $Content ->header('获取公众号已创建的标签')->body(view('admin.mass.thelabelmass',['arr'=>$arr]));
    }
    public function thelabelmasso(){
        $id=$_POST['id'];
        $text=$_POST['text'];
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=$access_token";
        $msg=[
            "filter"=>[
                "is_to_all"=>false,
                "tag_id"=>$id
            ],
             "text"=>["content"=>$text],
              "msgtype"=>"text"
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
}
?>

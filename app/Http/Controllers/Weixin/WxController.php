<?php

namespace App\Http\Controllers\Weixin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        print_r($data);die;
    }
}

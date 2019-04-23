<?php

namespace App\Http\Controllers\Jssdk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class JssdkController extends Controller{

    //jssdk 使用
    public function jssdk(){
        $jsapi_ticket=jsapi_ticket();
        $nonceStr=Str::random(10);
        $timestamp=time();
        $url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        // $res="jsapi_ticket$jsapi_ticket&noncestr$nonceStr&timestamp$timestamp&url$url";
        // //签名
        // $signature=sha1($res);
        $string1 = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $sign= sha1($string1);
        // dd($sign);
        $arr=[
            'appId'=>env('WX_APP_ID'),    // 必填，公众号的唯一标识
            'timestamp'=>$timestamp,     // 必填，生成签名的时间戳
            'nonceStr'=>$nonceStr,       // 必填，生成签名的随机串
            'signature'=>$sign     // 必填，签名
        ];
        dd($arr);
        return view('jssdk/jssdk',['arr'=>$arr]);
    }
}
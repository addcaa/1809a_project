<?php

namespace App\Http\Controllers\Qrcode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QrcodeController extends Controller
{
    //创建二维码ticket
    public function qrcode(){
        $access_token=getaccesstoken();
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $msg=[
            "expire_seconds"=>604800,
            "action_name"=>"QR_SCENE",
            "action_info"=>[
                "scene"=>["scene_id"=>"777"],
            ],
        ];
        $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // dd($data);
        $client = new Client();
        $r = $client->request('POST',$url, [
            'body' => $data
        ]);
        $obj=$r->getBody();
        $arr=json_decode($obj,true);
        dd($arr);
    }
    //通过ticket换取二维码
    public function generate(){
        $access_token=getaccesstoken();
        // dd($access_token);
        $url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQEC8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyZjNFMFlveEZjY0UxUUpfZTFzMU4AAgStRMVcAwSAOgkA";
        // $data=json_decode(file_get_contents($url),true);
        // dd($url);
    }
    /**商品转发 */
    public function goodsget(Request $request){
        // $wxconfig=$request->signPackage;
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
        $wxconfig=[
            'appId'=>env('WX_APP_ID'),    // 必填，公众号的唯一标识
            'timestamp'=>$timestamp,     // 必填，生成签名的时间戳
            'nonceStr'=>$nonceStr,       // 必填，生成签名的随机串
            'signature'=>$sign     // 必填，签名
        ];
        // dd($wxconfig);
        $arr=DB::table('goods')->where(['goods_id'=>8])->get()->toArray();
        // dd($arr);
        return view('qrcode/goodsget',['arr'=>$arr,'wxconfig'=>$wxconfig]);
    }
}

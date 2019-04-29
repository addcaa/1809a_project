<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class GoodsController extends Controller
{
    public function index(){
        // echo "商品展示";
        // dd(Auth::id());
        $user_name=DB::table('users')->where(['id'=>Auth::id()])->value('name');
        // dd($user_name);
        $goods_info=DB::table('goods')->get();
        // dd($goods_info);
        return view('goods.index',['goods_info'=>$goods_info,'user_name'=>$user_name]);
    }
    /**购物车*/
    public function cart($goods_id){
        // dd(Session::getId());
        //用户id
        $user_id=Auth::id();
        if($user_id==""){
            header('Refresh:3;url=/login');
            echo "请先登陆";
        }
        // echo $goods_id;die;
        $goods_info=DB::table('goods')->where(['goods_id'=>$goods_id])->first();
        $cart_info=DB::table('cart')->where(['user_id'=>$user_id,'goods_id'=>$goods_id])->first();
        // dd($goods_info);
        if($cart_info){
            $cart_num=DB::table('cart')->where(['user_id'=>$user_id,'goods_id'=>$goods_id])->value('cart_num');
            $num=[
                'cart_num'=>$cart_num+1,
                'cart_time'=>time(),
            ];
            $cartarr=DB::table('cart')->where(['user_id'=>$user_id,'goods_id'=>$goods_id])->update($num);
        }else{
            $info=[
                'goods_id'=>$goods_id,
                'goods_price'=>$goods_info->goods_price,
                'cart_num'=> +1,
                'user_id'=>$user_id,
                'session_id'=>Session::getId(), //绘画id
                'cart_time'=>time(),

            ];
            // dd($info);
            $cartarr=DB::table('cart')->insert($info);
        }
        if($cartarr){
            header('Refresh:3;url=/cart/index');
            echo "加入购物车成功";
        }else{
            header('Refresh:3;url=/goods/index');
            echo "加入购物车失败";
        }

    }
    public function list($goods_id){
        // $access_token=getaccesstoken();
        // $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        // $msg=[
        //     "expire_seconds"=>604800,
        //     "action_name"=>"QR_SCENE",
        //     "action_info"=>[
        //         "scene"=>["scene_id"=>$goods_id],
        //     ],
        // ];
        // $data=json_encode($msg,JSON_UNESCAPED_UNICODE);
        // // dd($data);
        // $client = new Client();
        // $r = $client->request('POST',$url, [
        //     'body' => $data
        // ]);
        // $obj=$r->getBody();
        // $arr=json_decode($obj,true);
        // // dd($arr);
        // $ticket=$arr['ticket'];
        // //转换二维码
        // $url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
        // dd($url);
        // $id='goods_id'.$goods_id;
        // $redis_incr=Redis::incr($id);
        // dd($redis_incr);



        //转发
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


        $url="http://1809cuifangfang.comcto.com/goods/list/$goods_id;";
        $goods_num=DB::table('goods')->where(['goods_id'=>$goods_id])->value('goods_num');
        $where=[
            'goods_num'=>$goods_num+1
        ];
        $num=DB::table('goods')->where(['goods_id'=>$goods_id])->update($where);
        // dd($num);
        $goods_info=DB::table('goods')->where(['goods_id'=>$goods_id])->first();
        //浏览记录
        $goods_num=DB::table('goods')->where(['goods_id'=>$goods_id])->first();
        // dd($goods_info);
        $data=[
            'goods_info'=>$goods_info,
            'url'=>$url,
            'wxconfig'=>$wxconfig,
        ];
        return view('goods/list',$data);
    }
}

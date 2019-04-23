<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redis;
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
        $id='goods_id'.$goods_id;
        $redis_incr=Redis::incr($id);
        // dd($redis_incr);
        $goods_num=DB::table('goods')->where(['goods_id'=>$goods_id])->value('goods_num');
        $where=[
            'goods_num'=>$goods_num+1
        ];
        $num=DB::table('goods')->where(['goods_id'=>$goods_id])->update($where);
        // dd($num);
        $goods_info=DB::table('goods')->where(['goods_id'=>$goods_id])->first();

        //浏览记录
        $goods_num=DB::table('goods')->where(['goods_id'=>$goods_id])->first();
        $key="jilu";
        Redis::Zadd($key,$redis_incr,$goods_id);
        $res=Redis::zRevRange($key,0,100,true);
        $arr_info=[];
        foreach($res as $k=>$v){
            $arr_info[]=DB::table('goods')->where(['goods_id'=>$k])->first();
        }
        $data=[
            'goods_info'=>$goods_info,
            'redis_incr'=>$redis_incr,
            'arr_info'=>$arr_info
        ];
        return view('goods/list',$data);
    }
}

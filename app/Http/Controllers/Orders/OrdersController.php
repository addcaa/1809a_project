<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class OrdersController extends Controller
{
    //立即购买
    public function index(){
        $cart_id=$_GET['cart_id'];
        $rand=$this->rand();
        // dd($rand);
        $user_id=Auth::id();
        $cart_info=DB::table('cart')->where(['cart_id'=>$cart_id])->first();
        $goods_info=DB::table('cart')->where(['cart_id'=>$cart_id])->join('goods','cart.goods_id','=','goods.goods_id')->first();
        // dd($goods_info);
        $cart_num=$cart_info->cart_num;
        // echo $cart_num.',';
        $goods_price=$cart_info->goods_price;
        // echo $goods_price;
        $arr=array("$cart_num","$goods_price");
        $totalprices=array_product($arr);
        // dd($totalprices);
        $order_info=[
            'on_order'=>$rand,
            'totalprices'=>$totalprices     //总价
        ];
        $order_res=DB::table('order')->insert($order_info);
        // dd($order_res);
        $ordere_id = DB::getPdo('ordere')->lastInsertId();
        // dd($ordere_id);
        $orders_detail_info=[
            'oid'=>$ordere_id,
            'goods_name'=>$goods_info->goods_name,
            'goods_id'=>$goods_info->goods_id,
            'goods_price'=>$goods_info->goods_price,
            'user_id'=>$user_id,
        ];
        $order_res=DB::table('orders_detail')->insert($orders_detail_info);
        // dd($order_res);
        if($order_res=true&&$order_res=true){
            header('Refresh:1;url=/orders/order');
            echo "正在加载~~~";

        }else{
            header('Refresh:3;url=/index');
            echo "购买失败";
        }
    }
    //订单号
    public function rand(){
        return $rand = time().'cuifang'.mt_rand(11111,99999);
    }
    public function order(){
        $order_info=DB::table('order')->get();
        return view('orders.order',['order_info'=>$order_info]);
    }

}

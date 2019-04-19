<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        // echo "购物车";
        $user_id=Auth::id();
        $where=[
            'user_id'=>$user_id
        ];
        // $goods_id=DB::table('cart')->where($where)->pluck('goods_id');
        // // dd($goods_id);
        // // var_dump($goods_id);die;
        // $where=[
        //     'goods_id'=>$goods_id
        // ];
        $cart_info=DB::table('cart')->join('goods','cart.goods_id','=','goods.goods_id')->get();
        // dd($cart_info);

        return view('cart.index',['cart_info'=>$cart_info]);
    }
}

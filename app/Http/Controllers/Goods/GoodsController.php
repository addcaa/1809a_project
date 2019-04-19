<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        echo $goods_id;die;
        // $
    }
}

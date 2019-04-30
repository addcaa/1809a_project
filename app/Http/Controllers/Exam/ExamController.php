<?php

namespace App\Http\Controllers\Exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
class ExamController extends Controller
{
    //
    public function exam(){
        // echo "11";
        $s_name=Redis::get("goods_scc");
        $info=[
            's_name'=>$s_name
        ];
        $arr=DB::table("seek_goods")->insert($info);
        dd($arr);
    }
}

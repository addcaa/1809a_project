<?php

namespace App\Http\Controllers\Crontab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class CrontabController extends Controller
{
    //
    public function delorders(){
        echo __METHOD__."\n";
        $arr=DB::table('order')->get();
        // dd($arr);
        foreach($arr as $k=>$v){
            if(time() - $v->add_time > 1800 && $v->pay_time==0){
                //设置删除状态
                $res=DB::table('order')->where(['oid'=>$v->oid])->update(['is_delete'=>1]);
            }
        }
    }
}

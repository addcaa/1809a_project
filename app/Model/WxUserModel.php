<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxUserModel extends Model
{
    //添加这两个，最下面的，因为我是手工建表
    protected $table = 'wx_user';
    public $timestamps = false;
}

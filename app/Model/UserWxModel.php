<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserWxModel extends Model
{
    //添加这两个，最下面的，因为我是手工建表
    protected $table = 'userwx';
    public $timestamps = false;
    protected $primaryKey="uid";
}

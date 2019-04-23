<?php

namespace App\Http\Controllers\Jssdk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetimgController extends Controller
{
    public function geting(){
        dd($_GET);
    }
}

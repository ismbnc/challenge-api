<?php

namespace App\Http\Controllers\Api;

use App\Classes\Tools\ReturnClass;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index($method = null)
    {

        if ($method == null) {
            $method = request()->segment(count(request()->segments()));
            //return json_encode(new ReturnClass(false, "İşlem yapmak istenilen URL hatalı! Method mevcut değil."), JSON_UNESCAPED_UNICODE);
        }

        $route = request()->segment(2);

        $uroute = ucfirst($route); /* merhaba/MERHABA = Merhaba */
        
        $classname = "\\App\\Classes\\Api\\" . $uroute;

        if (!class_exists($classname)) {
            return json_encode(new ReturnClass(false, "İşlem yapmak istenilen URL hatalı!"), JSON_UNESCAPED_UNICODE);
        }
        if (!method_exists($classname, "$method")) {
            return json_encode(new ReturnClass(false, "İşlem yapmak istenilen URL hatalı! Method mevcut değil."), JSON_UNESCAPED_UNICODE);
        }

        $cls = null;
        $rs = 'null';

        eval('$cls = new ' . $classname . '();');
        eval('$rs = $cls->' . $method . '();');
        return response(json_encode($rs, JSON_UNESCAPED_UNICODE), 200)->header('Content-Type', 'application/json');
//        return json_encode($rs, JSON_UNESCAPED_UNICODE);
    }
}

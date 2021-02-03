<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

class WsdlController extends Controller
{
    public function generate($param)
    {
        eval('$this->wsdl_' . $param.'();');
    }

}
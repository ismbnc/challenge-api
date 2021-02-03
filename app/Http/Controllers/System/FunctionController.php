<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use function url;
use Illuminate\Support\Facades\Artisan;

class FunctionController extends Controller
{
    public static function requestcontrol()
    {
        $kontrol = true;
        
        // $kontrol = !(strstr(request()->url(), '/js/') != false ||
        // strstr(request()->url(), '/images/') != false ||
        // strstr(request()->url(), '/css/') != false ||
        // strstr(request()->url(), '/fonts/') != false ||
        // strstr(request()->url(), '/font/') != false ||
        // strstr(request()->url(), '/fonts/') != false);

        // if ($kontrol){
            if (request()->ip() == '127.0.0.1' || request()->ip() == '213.254.137.33' || strstr(request()->ip(), '192.') != false) { // && strstr(request()->url(), '/api/') == false
                FunctionController::clear();
            }    
        //}
        $kontrol = true;
        return $kontrol;

    }

    public static function getrquestcode()
    {
        $host = request()->getHost();
        $port = request()->getPort();

        if ($port == '80' || $port == '443') {
            $port = '';
        } else {
            $port = ':'.$port;
        }

        //url den host bilgilerini temizle
        $url = str_replace($host.$port, '', request()->url());
        $url = str_replace($host, '', $url);
        $url = str_replace('http://', '', $url);
        $url = str_replace('https://', '', $url);

        if ($url != '') {
            if (substr($url, 0, 1) == '/') {
                $url = substr($url, 1, strlen($url));
            }
        }

        // if ($url == '') {
        //     $url = 'analiz/genel';
        // }

        // if (request()->is('api/*')) {
        //     $url = str_replace('api/', '', $url);
        // }

        return $url;
    }

    public static function clear()
    {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        session()->flush();
    }

    public function index($param = '')
    {
        if ($param == '') {
            $param = 'all-clear';
        }

        switch ($param) {
            case 'models':
                exec('php '.base_path().'\artisan pursehouse:modeler');
            break;
            case 'all-clear':
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('config:clear');
                Artisan::call('config:cache');
                Artisan::call('route:clear');

                session()->flush();
                break;
            case 'cache-clear':
                Artisan::call('cache:clear');
                break;
            case 'config-clear':
                Artisan::call('config:clear');
                break;
            case 'view-clear':
                Artisan::call('view:clear');
                break;
            case 'optimize':
                Artisan::call('optimize');
                break;
            case 'session-clear':
                session()->flush();
                break;
            default:
                return 'No Param!';
        }

        return $param.' runned.';
    }
}

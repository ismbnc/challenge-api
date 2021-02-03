<?php

namespace App\Http\Middleware;

use App\Classes\System\ReconnectClass;
use App\Classes\System\SecurityClass;
use App\Classes\Tools\General;
use App\Classes\Tools\ReturnClass;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

use function session;
use Illuminate\Support\Facades\DB;

class AppLogin
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        session()->flush();

        $kullanici = null;
        $sifre = null;

        if (isset($_SERVER["HTTP_KULLANICI"]) && isset($_SERVER["HTTP_SIFRE"])) {
            $kullanici = $_SERVER["HTTP_KULLANICI"];
            $sifre = $_SERVER["HTTP_SIFRE"];

            $kurum = DB::table("nbys_isg_master.kurum")->where("LISANSKOD", $kullanici)->select("ID", "LISANSKOD", "KURUMAD", "API_PASS")->first();

            $rv = new ReturnClass();

            if ($kurum == null) {
                $rv->mesaj = "Kullanıcı adınıza ait kayıt bulunamadı!";
            }else  if ($kurum->API_PASS == null || $kurum->API_PASS == "") {
                $rv->mesaj = "API şifresinizi henüz oluşturulmamış! Lütfen yönetici hesabı ile programa giriş yapıp Yönetim > API Şifre İşlemleri menüsünden şifrenizi oluşturunuz.";
            }else  if ($kurum->API_PASS != $sifre) {
                $rv->mesaj = "API şifresiniz hatalı!";
            }

            $this->add_log($kurum, $rv);

            if ($rv->mesaj != ""){
                return response(json_encode($rv, JSON_UNESCAPED_UNICODE), 200);
            }


            $this->db_change($kurum);

            return $next($request);
        } else {
            $rv = new ReturnClass(false, "API Kullanıcı bilgileri hatalı!");

            $this->add_log(null, $rv);

            return response(json_encode($rv, JSON_UNESCAPED_UNICODE), 200);
        }
    }

    private function add_log($kurum = null, $status){
        DB::table("nbys_isg_master_api.log")->insert([
            "kurum_id" =>  $kurum != null ? $kurum->ID : null,
            "create_date" => Carbon::now(),
            "ipadres" => General::getRealIpAddr(),
            "url" => request()->url(),
            "header" => json_encode($_SERVER),
            "request" => json_encode(request()->all()),
            "status" => $status->mesaj == "" ? 1 : 0,
            "status_text" => $status->mesaj
        ]);
    }
    private function db_change($kurum){
        $rv = new ReturnClass();
        try {
            $kurumid = $kurum->ID;
            if (in_array("apitest", request()->segments())){
                $kurumid = 1;
                session()->put("test", true);
            }

            $kurumdb = DB::table("nbys_isg_master.kurum_db AS db")
                ->join("nbys_isg_master.sunucu AS s", "s.ID", "=", "db.SUNUCU_ID")
                ->where("KURUM_ID", $kurumid)->orderByDesc("ID")
                ->select("s.*", "db.DBNAME")
                ->first();


            if ($kurumdb != null) {
                //db host u proje config host a eşit ise db use kullan, değil ise connect ol
                if ($kurumdb->HOST == config("database.connections.mysql.host")) {
                    config(['database.connections.mysql.database' => $kurumdb->DBNAME]);
                } else {
                    config(['database.connections.mysql.host' => $kurumdb->HOST]);
                    config(['database.connections.mysql.database' => $kurumdb->DBNAME]);
                    config(['database.connections.mysql.username' => $kurumdb->USER]);
                    config(['database.connections.mysql.password' => $kurumdb->PASS]);
                    config(['database.connections.mysql.port' => $kurumdb->PORT]);
                }

                DB::purge('mysql');
                DB::reconnect('mysql');

                $rv->durum = true;
                $rv->mesaj = "Veri bağlantısı düzenlendi.";
            } else {
                $rv->mesaj = "Kullanıcı giriş bilgilerine erişilemedi!";
            }
        } catch (\Throwable $th) {
            $rv->mesaj = General::error_message($th, "ReconnectClass->connect()");
        }

        return $rv;
    }
}

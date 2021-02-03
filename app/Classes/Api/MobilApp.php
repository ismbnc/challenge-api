<?php


namespace App\Classes\Api;

use App\Classes\Tools\Read;
use App\Classes\Tools\ReturnClass;
use App\Models\Deneme\Purchase;
use App\Models\Deneme\Register;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

class MobilApp
{


    public function __construct()
    {
        
    }

    public function register(){
        $rv = new ReturnClass();
        try {
            $uid = Read::get('uid');
            $appid = Read::get('appid');
            $langid = Read::get('langid');
            $os = Read::get('osid');
            
            $reg = Register::where('u_id',$uid)->where('app_id',$appid)->first();
            if ($reg != null){
                $rv->mesaj = 'OK';
                $rv->durum = true;
                $rv->obj = $reg->client_token;
            }
            else{
                $client_token = Uuid::uuid4();
                DB::table('register')->insert(['u_id' => $uid,
                                               'app_id' => $appid,
                                               'lang_id' => $langid,
                                               'os_id' => $os,
                                               'durum' => 1,
                                               'client_token' =>$client_token]);


                /* istenir ise model ile de olusturulup kayıt edilebilir . $reg = new Register(); */                                
            
                $rv->durum = true; 
                $rv->obj = $client_token; 
                $rv->mesaj = 'İşlem Başarılı'; 
                
            }
        } catch (\Throwable $th) {
            $rv->mesaj =  "MobilApp -> register() ".$th->getTraceAsString();
        }
        return $rv;
    }

    public function purchase(){
        //<test edilecek hash> $2y$10$17xUwGUbb8ZdaOM.GqhGnuzlPsVcshf7k8hj9HfrlaV.z9By27gBK
        //<client_token>       885702a0-ad36-4d8e-b2f9-07350e9424cd
        $rv = new ReturnClass();
        $client_token = Read::get('c_token');
        $hash = Read::get('hash');
        $url = "https://6017ea7f971d850017a3f2dc.mockapi.io/api/check/state/";
        try {
            $result = $this->mockApi($url,$hash) ;
            if ($result=='Not found'){
                $rv->mesaj = "Hash bilgisi doğrulanamadı..!";
            }
            else if (is_numeric(substr($result->id, -1)) && (substr($result->id, -1)%2==1)) {
                $purchase = new Purchase();
                $purchase->client_token = $client_token;
                $purchase->hash = $hash;
                $purchase->durum = 1;
                $purchase->kayit_zamani = Carbon::now();
                if($purchase->save()){
                    $rv->durum = true;
                    $rv->mesaj = "OK. | Kayit zamani : ".$purchase->kayit_zamani;
                }
                else{
                    $rv->mesaj = "Kayıt İşlemi başarısız..!";
                }
            }
            else{
                $rv->mesaj = 'Son karakter sayı ve tek sayı olmalıdır..!';
            }
        }
        catch (\Throwable $th) {
            $rv->mesaj =  "MobilApp -> purchase() ".$th->getTraceAsString();
        } 
        return $rv;
    }

    public function checkSub(){
        $rv = new ReturnClass();
        try {
            $client_token = Read::get('c_token');
            $appid = Read::get('appid');
            $u_id = Register::where('client_token',$client_token)->first()->u_id;
            if ($u_id == null){
                $rv->mesaj = 'Sisteme kayıtlı böyle bir user bulunamadı..!';
            }
            else{
                $result = DB::select('SELECT *,DATEDIFF(s.bitis_tarih,?) as a FROM subscriptions AS s 
                                    WHERE s.app_id=? AND s.u_id=? AND ? 
                                    BETWEEN s.basl_tarih AND s.bitis_tarih',
                                    [Carbon::now()->format('Y-m-d'),$appid,$u_id,Carbon::now()->format('Y-m-d')]);

            }
            if (count($result)>0){
                $rv->durum = true;
                $rv->mesaj = 'Abonelik durumunuz güncel.Kalan Gün:'.$result[0]->a.' uid:'.$result[0]->u_id;

            } 
        } catch (\Throwable $th) {
            $rv->mesaj =  "MobilApp ->checkSub() ".$th->getTraceAsString();
        }
        return $rv;

    }

    public function mockApi($url,$hash){
        // https://6017ea7f971d850017a3f2dc.mockapi.io/api/check/state/$2y$10$17xUwGUbb8ZdaOM.GqhGnuzlPsVcshf7k8hj9HfrlaV.z9By27gBK
        $ch = curl_init($url.$hash);
        curl_setopt($ch, CURLOPT_URL, $url.$hash);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);
    }

}

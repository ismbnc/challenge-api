<?php

namespace App\Classes\Tools;

class ReturnClass
{
    public $durum = false;
    public  $mesaj = '';

    public function __construct($durum = null, $mesaj = null)
    {
        if (!is_null($durum) && $durum != null) {
            $this->durum = $durum;
        }
        if (!is_null($mesaj) && $mesaj != null) {
            $this->mesaj = $mesaj;
        }
    }
}

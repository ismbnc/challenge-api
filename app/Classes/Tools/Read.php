<?php

namespace App\Classes\Tools;

use function request;

class Read
{
    public static function json($isarray = false)
    {
        $all = request()->all();

        $values = [];
        foreach ($all as $key => $val) {
            if ($val == "null") {
                $val = null;
            }
            $values = array_merge($values, [$key => $val]);
        }

        $values = json_decode(json_encode($values));

        if ($isarray == true) {
            $values = (array)$values;
        }

        return $values;
    }

    public static function get($name, $default = null)
    {
        try {
            $splt = explode(".", $name);

            if (count($splt) > 1) {
                $first = Read::_get($splt[0]);

                if ($first == null) {
                    return $default;
                } else {
                    if (substr($first, 0, 1) == "{") {
                        $first = json_decode($first, true);
                        for ($i = 1; $i < count($splt); $i++) {

                            eval('$first = $first["' . $splt[$i] . '"];');

                            if (substr($first, 0, 1) == "{") {
                                $first = json_decode($first);
                            }
                        }
                    }

                    return $first;
                }
            } else {
                return Read::_get($splt[0], $default);
            }
        } catch (\Throwable $th) {
            return $default;
        }
    }

    private static function _get($name, $default = null)
    {
        $param = request()->input($name);

        if ($param == null){
            eval('$param = request()->' . $name . ';');
            $param .= "";
        }

        if ($param == null) {
            $param = request()->file($name);

            if ($param != null) {
                return $param;
            }
        }

        if ($param == "null") {
            $param = null;
        }

        if ($param !== null && $param !== '') {
            if (is_string($param)){
                if (substr($param, 0, 1) == '{' && substr($param, -1) == '}') {
                    $param = json_decode($param);
                    return $param;
                }else if (substr($param, 0, 1) == '[' && substr($param, -1) == ']') {
                    $param = str_replace('[', '', str_replace(']', '', $param));
                    $param = explode(',', $param);
                }
            }

            if (is_array($param)) {
                return $param;
            } else {

                if ($default != null && $param == '') {
                    $param = $default;
                }

                return trim($param);

                return str_replace("'", '&#39;', trim($param));
            }
        } else {
            $js = Read::json();

            if ($js != null) {
                $sonuc = null;

                try {
                    eval('$sonuc = $js->' . $name . ';');
                } catch (\Throwable $th) {
                    //throw $th;
                }

                if ($sonuc == "null") {
                    $sonuc = null;
                }

                if ($sonuc != null) {
                    return $sonuc;
                }
            }

            return $default;
        }
    }
}

<?php

namespace App\Helper;

class ModelHelper{

    public static function orderSql(string $column, array $val) : string {
        $conn = env('DB_CONNECTION','mysql');
        if($conn === 'mysql') {
            $str = implode("','", $val);
            return "FIELD(`".$column."`,'".$str."')";
        } else {
            $str = implode("','", $val);
            return "array_position(array[\"".$str."\"], ".$column.");";
        }
    }
}
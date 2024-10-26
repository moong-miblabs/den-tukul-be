<?php

namespace App\Helper;

class ControllerHelper{

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

    public static function stringToSingleArray(string $str) : array {
        return explode(',',$str);
    }

    public static function stringToMultipleArray(string $str) : array {
        $parent = explode('.', $str);
        $child = array_map(fn ($child) => explode(',',$child), $parent);
        return $child;
    }
}
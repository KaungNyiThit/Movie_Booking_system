<?php

namespace Helpers;

class HTTP{

    static $url = "http://localhost/Movie-Booking-System";

    static function redirect($path, $query=""){
        $url = static::$url . $path;

        if($query){
            $url .= "?$query";
        }

        header("location: $url");
        exit();
    }
}

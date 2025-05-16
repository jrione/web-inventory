<?php

namespace App\Core;

class Helper{

    public static function receiveDataJSON($validPayload){
        header('Content-Type: application/json');
        $data = file_get_contents("php://input");
        $decoded = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return null;
        }

        array_walk_recursive($decoded, function (&$value) {
            if (is_string($value)) {
                $value = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
        });
        
        $receivedKeys = array_keys($decoded ?? []);
        $validatePayload=array_diff($validPayload,$receivedKeys);
        if(!empty($validatePayload)){
            return Route::bad_request();
        }
        
        return $decoded;
    }

    public static function returnDataJSON($arr,$err_code=0){
        header('Content-Type: application/json');
        $data ="";
        is_array($arr)
            ? $data = json_encode($arr, JSON_PRETTY_PRINT)
            : $data = json_encode(array($arr), JSON_FORCE_OBJECT);
        
        switch($err_code){
            case 400:
               return Route::bad_request($data);
            case 500:
                return Route::internal_error($data);
            default:
                echo $data;
        }
        
        
       
    }
}
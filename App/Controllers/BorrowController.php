<?php

namespace App\Controllers;
use App\Core\Helper as H;
use App\Core\Database as DB;

class BorrowController{
    public static $validPayload = [];
    
    public static function getAllBorrow(){
        $roles = H::BasicAuth();

        $q="SELECT*FROM tb_item_borrowed";
        $res = DB::queryRaw($q);
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }
    }
    public static function getBorrowById(){
        $roles = H::BasicAuth();
        self::$validPayload = ["id_item_borrowed"];
        $payload=H::receiveDataJSON(self::$validPayload);
        
        $q="SELECT*FROM tb_item_borrowed WHERE id_item_borrowed=? ";
        $res = DB::queryRaw($q,array_values($payload));
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }

    }
    public static function updateBorrow(){
        $roles = H::BasicAuth();

    }
    public static function deleteBorrow(){
        $roles = H::BasicAuth();

    }
}
<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;

class UserController{
    public static $validPayload = [];
    public static function getAllUser(){
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        
        $q="SELECT*FROM tb_user";
        $res = DB::queryRaw($q);
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }
    }

    public static function getUserById(){
        $roles = H::BasicAuth();
        self::$validPayload = ["user_id"];
        $payload=H::receiveDataJSON(self::$validPayload);
        
        $q="SELECT*FROM tb_user WHERE user_id=? ";
        $res = DB::queryRaw($q,array_values($payload));
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }
    }

    public static function updateUser(){
        $roles = H::BasicAuth();
        self::$validPayload = array("where","dataUpdated");
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        $payload=H::receiveDataJSON(self::$validPayload);
        $update=[];
        foreach($payload["dataUpdated"] as $key => $val){
            array_push($update,$key."='".$val."'");
        }
        $state=implode(", ", $update);

        
        $w=[];
        foreach($payload["where"] as $key => $val){
            array_push($w,$key."='".$val."'");
        }

        $q="UPDATE tb_user SET ".$state." WHERE ". $w[0];
        try{
            DB::queryRaw($q);
        } catch(\PDOException $e){
            $returnData = H::returnDataJSON(["unexpected_error" => $e->getMessage()],500);
            return $returnData;
            exit();
        }
        return H::returnDataJSON(["success" => "Data Berhasil diubah!"]);
    }

    public static function deleteUser(){
        self::$validPayload = array("user_id");
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        $payload=H::receiveDataJSON(self::$validPayload);

        $q="DELETE FROM tb_user WHERE user_id=".$payload["user_id"];
        try{
            DB::queryRaw($q);
        } catch(\PDOException $e){
            $returnData = H::returnDataJSON(["unexpected_error" => $e->getMessage()],500);
            return $returnData;
            exit();
        }
        return H::returnDataJSON(["success" => "Data Berhasil dihapus!"]);
    }
}
<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;

class ApiController{
    private static $validPayload = array();
    
    public static function insertData(){
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        
        self::$validPayload = array("kode_barang","nama_barang","jumlah_barang","satuan_barang","harga_beli");
        $payload=H::receiveDataJSON(self::$validPayload);

        $q="INSERT INTO tb_inventory(".implode(', ',self::$validPayload).") VALUE(?, ?, ?, ?, ?)";
        $dataBarang= [];
        foreach($payload as $p){
            array_push($dataBarang,$p);
        }

        try{
            DB::queryRaw($q,$dataBarang);
        } catch(\PDOException $e){
            ($e->getCode() == 23000)
                ? $returnData = H::returnDataJSON(["message" => "Kode Barang Sudah Ada!"],400)
                : $returnData = H::returnDataJSON(["message" => $e->getMessage()],500);
            return $returnData;
        }
        return H::returnDataJSON(["success" => "Barang Telah Ditambahkan"]);
    }

    public static function getDataByKode(){
        $roles = H::BasicAuth();
        self::$validPayload = ["kode_barang"];
        $payload=H::receiveDataJSON(self::$validPayload);
        
        $q="SELECT*FROM tb_inventory WHERE kode_barang=? ";
        $res = DB::queryRaw($q,array_values($payload));
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["message" => "Unexpected Error"],500);
        }
        
    }

    public static function getAllData(){
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["message" => "Unauthorized"],401);
            exit();
        }
        
        $q="SELECT*FROM tb_inventory";
        $res = DB::queryRaw($q);
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid);
        }
        else{
            return H::returnDataJSON(["message" => "Unexpected Error"],500);
        }
        
    }

    public static function updateDataBarang(){
        self::$validPayload = array("where","dataUpdated");
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["message" => "Unauthorized"],401);
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

        $q="UPDATE tb_inventory SET ".$state." WHERE ". $w[0];
        try{
            DB::queryRaw($q);
        } catch(\PDOException $e){
            $returnData = H::returnDataJSON(["message" => $e->getMessage()],500);
            return $returnData;
            exit();
        }
        return H::returnDataJSON(["message" => "Data Berhasil diubah!"]);
    }

    public static function deleteDataByID(){
        self::$validPayload = array("id_barang");
        $roles = H::BasicAuth();
        if($roles != "admin"){
            return H::returnDataJSON(["message" => "Unauthorized"],401);
            exit();
        }
        $payload=H::receiveDataJSON(self::$validPayload);

        $q="DELETE FROM tb_inventory WHERE id_barang=".$payload["id_barang"];
        try{
            DB::queryRaw($q);
        } catch(\PDOException $e){
            $returnData = H::returnDataJSON(["message" => $e->getMessage()],500);
            return $returnData;
            exit();
        }
        return H::returnDataJSON(["message" => "Data Berhasil dihapus!"]);

    } 
}
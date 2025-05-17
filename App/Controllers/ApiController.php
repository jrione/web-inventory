<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;

class ApiController{
    private static $validPayload = array();
    
    public static function insertData(){
        $roles = H::BasicAuth($dataAuth);
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
                ? $returnData = H::returnDataJSON(["error" => "Kode Barang Sudah Ada!"],400)
                : $returnData = H::returnDataJSON(["unexpected_error" => $e->getMessage()],500);
            return $returnData;
        }
        return H::returnDataJSON(["success" => "Barang Telah Ditambahkan"]);
    }

    public static function getAllData(){
        $roles = H::BasicAuth($dataAuth);
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        
    }

    public static function getDataByKode(){
        $roles = H::BasicAuth($dataAuth);
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
        
    }

    public static function updateDataBarang(){
        $roles = H::BasicAuth($dataAuth);
        if($roles != "admin"){
            return H::returnDataJSON(["error" => "Unauthorized"],401);
            exit();
        }
    }
}
<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;
use App\Core\View as V;

class UserController{
    public static $validPayload = [];
    public static $data = [];

    private static function handleFileUpload($file) {
        $uploadDir = BASE_PATH.'public/assets/img/';
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg' ];
        $maxSize = 2 * 1024 * 1024;
        
        if(!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'message' => 'Format file tidak didukung'];
        }
        
        if($file['size'] > $maxSize) {
            return ['success' => false, 'message' => 'File terlalu besar (max 2MB)'];
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'profile_' . time() . '_' . rand(1000,9999) . '.' . $extension;
        $uploadPath = $uploadDir . $filename;
        
        if(!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        if(move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'filename' => $filename];
        } else {
            return ['success' => false, 'message' => 'Gagal upload file'];
        }
    }

    public static function index(){
        session_start();
        H::sessionCheck();

        
        $q="SELECT*FROM tb_inventory WHERE status_barang=1 AND jumlah_barang != 0";
        $res = DB::queryRaw($q);
        if ($res){
            $dataBarang = $res->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        ob_start(); 
        @self::getUserById(true,["user_id" => $_SESSION['user_id']]);
        $dataUser = json_decode(ob_get_contents());
        ob_end_clean();        

        self::$data = [
            "title" => "JriOne's Inventory",
            "dataAllBarang" => $dataBarang,
            "dataUser" => array_pop($dataUser)
        ];
        V::render("header",self::$data);
        V::render("user/index",self::$data);
    }

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

    public static function getUserById($bypass=false,$payloadParams=[]){
        if(!$bypass){        
            $roles = H::BasicAuth();
            self::$validPayload = ["user_id"];
            $payload=H::receiveDataJSON(self::$validPayload);
        }
        else{
            $payload=$payloadParams;
        }
        
        $q="SELECT*FROM tb_user WHERE user_id=? ";
        $res = DB::queryRaw($q,array_values($payload));
        if ($res){
            $dataValid = $res->fetchAll(\PDO::FETCH_ASSOC);
            return H::returnDataJSON($dataValid,200,false);
        }
        else{
            return H::returnDataJSON(["error" => "Unexpected Error"],500);
        }
    }

    public static function uploadProfile(){
        $roles = H::BasicAuth();
        if(!empty($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === 0) {
            $uploadResult = self::handleFileUpload($_FILES['foto_profil']);
            if($uploadResult['success']) {
                $uploadedFileName = $uploadResult['filename'];
                $dataUpdated['foto_profil'] = $uploadedFileName;
                $params=[
                    "where" => [
                        "user_id" => htmlspecialchars($_POST['user_id'])
                    ],
                    "dataUpdated" => [
                        "img" => $uploadedFileName
                    ]
                ];
                self::updateUser(true,$params);
                var_dump($uploadedFileName);
            } else {
                return H::returnDataJSON(["error" => $uploadResult['message']], 400);
            }
        }
    }

    public static function updateUser($bypass=false,$payloadParams=[]){
        if(!$bypass){        
            $roles = H::BasicAuth();
            self::$validPayload = array("where","dataUpdated");
            $payload=H::receiveDataJSON(self::$validPayload);
        }
        else{
            $payload=$payloadParams;
        }
        
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

        $q="DELETE FROM tb_user WHERE user_id=".$payload['user_id'];
        try{
            DB::queryRaw($q);
        } catch(\PDOException $e){
            $returnData = H::returnDataJSON(["unexpected_error" => $e->getMessage()],500);
            return $returnData;
            exit();
        }
        return H::returnDataJSON(["message" => "Data Berhasil dihapus!"]);
    }
}
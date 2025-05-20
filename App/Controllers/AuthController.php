<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;

class AuthController{
    private static $validRegisterPayload = array("username","full_name","email","password");
    private static $validLoginPayload = array("username","password");

    public static function loginProccess(){
        session_start();

        $data=H::receiveDataJSON(self::$validLoginPayload);

        $q = "SELECT*FROM tb_user WHERE username=?";
        try{
            $res = DB::queryRaw($q,[$data["username"]]);
            if($res){
                $dataValid = $res->fetch(\PDO::FETCH_ASSOC);
                $isPasswordValid=password_verify($data['password'],$dataValid['password']);
                if($isPasswordValid){
                    $_SESSION["username"] = $data["username"];
                    $_SESSION["password"] = $data["password"];
                    $_SESSION["roles"] = $dataValid["roles"];
                    $returnValue = H::returnDataJSON(["message" => "Sukses Login"]);
                }
                else{
                    $returnValue = H::returnDataJSON(["message" => "Username atau Password Salah!"],401);
                }
            }
            else{
                $returnValue = H::returnDataJSON(["message" => "Username atau Password Salah!"],401);
            }
        } catch(\PDOException $e){
            $returnValue =  H::returnDataJSON(["message" => $e->getMessage()],500);
        }
        return $returnValue;
    }

    public static function registerProccess(){
        $data=H::receiveDataJSON(self::$validRegisterPayload);

        $q = "INSERT INTO tb_user(".implode(', ',self::$validRegisterPayload).") VALUE(?, ?, ?, ?)";
        $dataValid = [];
        $data["password"] = password_hash($data["password"],PASSWORD_BCRYPT);
        foreach($data as $d){
            array_push($dataValid,$d);
        }

        try{
            DB::queryRaw($q,$dataValid);
        } catch(\PDOException $e){
            ($e->getCode() == 23000)
                ? $returnData = H::returnDataJSON(["message" => "Username telah dipakai!"],400)
                : $returnData = H::returnDataJSON(["message" => $e->getMessage()],500);
            return $returnData;
        }

        return H::returnDataJSON(["message" => "Berhasil Mendaftar"]);
    }

    public static function logoutProccess(){
        session_start();
        session_destroy();
        header("Location: ". BASE_URL);
    }
}
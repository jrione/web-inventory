<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;

class AuthController{
    private static $validRegisterPayload = array("username","full_name","email","password");
    private static $validLoginPayload = array("username","password");

    public static function loginProccess(){
        $data=H::receiveDataJSON(self::$validLoginPayload);
        return H::returnDataJSON(["password" => password_verify($data['password'],'$2y$10$R9OweUvJBWGZNCGZuYkMdOrFoyMKHtvdqRGbtdBbe5WN9cg8uofwC')]);
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
                ? $returnData = H::returnDataJSON(["error" => "Username telah dipakai!"],400)
                : $returnData = H::returnDataJSON(["unexpected_error" => $e->getMessage()],500);
            return $returnData;
        }

        return H::returnDataJSON(["success" => "Berhasil Mendaftar"]);
    }
}
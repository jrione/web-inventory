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
            case 401:
                return Route::unauthorized($data);
            case 500:
                return Route::internal_error($data);
            default:
                echo $data;
        }
        
    }

    public static function sessionCheck(){
        if (!isset($_SESSION['username']) AND !isset($_SESSION['roles'])) {
            session_destroy();
            return Route::unauthorized();
        }
    }

    public static function adminCheck(){
        if($_SESSION['roles'] !== "admin"){
            header("Location: ".BASE_URL."user/");
        }
    }

    public static function BasicAuth(){
        header('Content-Type: application/json');
        $data= array(
            "username" => $_SERVER["PHP_AUTH_USER"],
            "password" => $_SERVER["PHP_AUTH_PW"]
        );

        $q="SELECT username,password,roles FROM tb_user WHERE username=?";
        $stmt = Database::queryRaw($q,[$data["username"]]);
        if($stmt){
            $dataValid = $stmt->fetch(\PDO::FETCH_ASSOC);
            $isPasswordValid=password_verify($data['password'],$dataValid['password']);
            if(!$isPasswordValid){
                return Route::unauthorized(json_encode(["error" => "Unauthorized"]));
            }
            return $dataValid['roles'];
            exit();
        }
    }
}
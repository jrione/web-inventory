<?php

namespace App\Core;
use PDO;

class Database{
    private static $dsn;

    public static function connect(){
        self::$dsn=sprintf('mysql:host=%1$s;dbname=%2$s;charset=utf8;user=%3$s;password=%4$s',DB_HOST,DB_NAME,DB_USER,DB_PASS);
        return new PDO(self::$dsn);
    }
    public static function queryRaw($q, $where = []){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare($q);
        return $stmt->execute($where);
        // return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
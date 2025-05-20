<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;
use App\Core\View as V;

class AdminController{
    public static $data = [];
    public static function home_admin(){
        session_start();
        H::adminCheck();
        H::sessionCheck();

        $q="SELECT*FROM tb_inventory";
        $res = DB::queryRaw($q);
        if ($res){
            $dataBarang = $res->fetchAll(\PDO::FETCH_ASSOC);
        }
        self::$data = [
            "title" => "JriOne's Inventory",
            "dataAllBarang" => $dataBarang
        ];
        V::render("header",self::$data);
        V::render("admin/index",self::$data);
    }
}
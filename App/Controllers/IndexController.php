<?php

namespace App\Controllers;
use App\Core\View as V;

class IndexController{
    public static function index(){
        $data = ["title" => "JriOne's Inventory"];
        V::render('header',$data);
        V::render('index');
    }
}
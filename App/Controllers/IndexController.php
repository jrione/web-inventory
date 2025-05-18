<?php

namespace App\Controllers;
use App\Core\View as V;

class IndexController{
    public static $data = ["title" => "JriOne's Inventory"];
    public static function index(){
        V::render('header',$data);
        V::render('navbar');
        V::render('index');
    }

    public static function login(){
        V::render("header",self::$data);
        V::render('login_form');
        V::render('foot');
    }

    public static function register(){
        V::render("header",self::$data);
        V::render('register_form');
        V::render('foot');
    }
}
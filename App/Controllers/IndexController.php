<?php

namespace App\Controllers;
use App\Core\View;

class IndexController
{
    public function index(){
        $data = ["title" => "JriOne's Inventory"];
        View::render('header',$data);
        View::render('index');
    }
}
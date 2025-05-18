<?php

namespace App\Controllers;
use App\Core\Database as DB;
use App\Core\Helper as H;
use App\Core\View as V;

class AdminController{

    public static function home_admin(){
        session_start();
        H::sessionCheck();
        H::adminCheck();
    }
}
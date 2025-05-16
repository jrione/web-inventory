<?php

namespace App\Core;

class View{
    public static function render($view,$data = []) {
        $file = BASE_PATH . 'views/'. $view . '.php';
        if(file_exists($file)){
            extract($data);
            require $file;
        }
        else{
            var_dump($file);
            var_dump(BASE_PATH);
            Route::not_found();
        }
    }
}
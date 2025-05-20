<?php

namespace App\Core;

class Route {
    private static $routes = [];

    public static function add($method, $path, $callback){
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public static function dispatch($method, $path){
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                if (!is_string($route['callback'])) {
                    return self::not_found();
                }
                list($class, $handlerMethod) = explode('@', $route['callback']);
                $class = "App\\Controllers\\$class";
                if (class_exists($class) && method_exists($class, $handlerMethod)) {
                    call_user_func([new $class, $handlerMethod]);
                    return;
                } else {
                    http_response_code(500);
                    echo "Handler not found";
                    return;
                }
            }
        }
        return self::not_found();
    }

    public static function not_found(){
        http_response_code(404);
        echo "404 Not Found";
        exit();
    }

    public static function bad_request($msg=''){
        http_response_code(400);
        if(!empty($msg)){
            echo $msg;
        }
        else{
            echo "400 Bad Request";
        }
        
        exit();
    }

    public static function unauthorized($msg=''){
        http_response_code(401);
        if(!empty($msg)){
            echo $msg;
        }
        else{
           echo "401 Unauthorized";
        }
    }

    public static function internal_error($err){
        http_response_code(500);
        echo $err;
        exit();
    }
}

<?php

use App\Core\Route;

// Home Route
Route::add('GET','/', 'IndexController@index');
Route::add('GET','/login', 'IndexController@login');
Route::add('GET','/register', 'IndexController@register');

// Auth Route
Route::add('POST','/auth/login','AuthController@loginProccess');
Route::add('POST','/auth/register','AuthController@registerProccess');

//Admin Route
Route::add('GET','/admin/dashboard','AdminController@home_admin');

//User Route
Route::add('GET','/dashboard','AdminController@home_admin');

//API Route
Route::add('GET','/api/users','ApiController@getAllUsers');
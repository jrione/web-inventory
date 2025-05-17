<?php

use App\Core\Route;

// Home UI Route
Route::add('GET','/', 'IndexController@index');
Route::add('GET','/login', 'IndexController@login');
Route::add('GET','/register', 'IndexController@register');


//Admin UI Route
Route::add('GET','/admin/dashboard','AdminController@home_admin');

//User UI Route
Route::add('GET','/user/dashboard','AdminController@home_admin');


// Auth Route TASK:DONE
Route::add('POST','/auth/login','AuthController@loginProccess');
Route::add('POST','/auth/register','AuthController@registerProccess');
Route::add('POST','/auth/logout','AuthController@logoutProccess');

//API barang TASK:DONE
Route::add('POST','/api/barang/create','ApiController@insertData'); //admin
Route::add('POST','/api/barang/listAll','ApiController@getAllData'); //user+admin
Route::add('POST','/api/barang/list','ApiController@getDataByKode'); //user+admin
Route::add('PATCH','/api/barang/update','ApiController@updateDataBarang'); //admin
Route::add('DELETE','/api/barang/delete','ApiController@deleteDataByID'); //admin

//API user mgmt TASK:DONE
Route::add('POST','/api/user/listAll','UserController@getAllUser'); //admin
Route::add('POST','/api/user/list','UserController@getUserById'); //admin
Route::add('PATCH','/api/user/update','UserController@updateUser'); //user+admin
Route::add('DELETE','/api/user/delete','UserController@deleteUser'); //admin

//API user borrow
Route::add('POST','/api/user/borrow/listAll','BorrowController@getAllBorrow'); //admin
Route::add('POST','/api/user/borrow/list','BorrowController@getBorrow'); //admin
Route::add('PATCH','/api/user/borrow/update','BorrowController@updateBorrow'); //user+admin
Route::add('DELETE','/api/user/borrow/delete','BorrowController@deleteBorrow'); //admin

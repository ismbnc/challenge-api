<?php

use Illuminate\Support\Facades\Route;

Route::get('fn', 'System\FunctionController@index');
Route::get('fn/{param}', 'System\FunctionController@index');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dokuman', function () {
    return view('dokuman');
});

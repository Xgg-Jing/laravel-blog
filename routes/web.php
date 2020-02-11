<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//后台分组
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    //后台登录页
    Route::get('login', 'LoginController@login');
    //后台验证码1
    Route::get('code', 'LoginController@code');
    //后台验证码2
    Route::get('code/captcha/{tmp}', 'LoginController@captcha');
    //登录操作
    Route::post('doLogin','LoginController@doLogin');
    //密码加密
    Route::get('jiami','LoginController@jiami');

    //后台首页
    Route::get('index','IndexController@index');
});
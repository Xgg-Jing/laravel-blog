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


    //前台分组
Route::get('/user','User\UserController@index');
Route::get('/article','User\UserController@article');
Route::get('/diary','User\UserController@diary');
Route::get('/link','User\UserController@link');
Route::get('/message','User\UserController@message');
Route::get('/read','User\UserController@read');

    //后台登录分组
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



});

    //errors没有权限的页面
    Route::get('noaccess','Admin\IndexController@noaccess');


    //后台界面分组
Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware' => ['isLogin',]], function () {
    //后台首页
    Route::get('index','IndexController@index');

    //后台欢迎页
    Route::get('welcome','IndexController@welcome');

    //后台退出登录
    Route::get('loginOut','IndexController@loginOut');

    //用户相关路由
    Route::resource('user','UserController');

    //批量删除用户路由
    Route::post('user/del','UserController@delAll');

    //用户统计
    Route::get('userWelcome','UserController@welcome');

    //用户角色相关路由
    Route::resource('role','RoleController');

    //批量删除用户路由
    Route::post('role/del','RoleController@delAll');

    //用户角色相关路由
    Route::resource('permission','PermissionController');

    //分类相关路由
    Route::resource('cate','CateController');

    //添加子类
    Route::get('cate/create/{id}','CateController@create');

    //批量删除分类路由
    Route::post('cate/del','CateController@delAll');

    //分类排序类路由
    Route::post('cate/order','CateController@order');

    //文章相关路由
    Route::resource('article','ArticleController');

    //图片上传路由
    Route::post('article/upload','ArticleController@upload');
});
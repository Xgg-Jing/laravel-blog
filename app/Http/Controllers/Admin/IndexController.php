<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //后台首页跳转
    public function index(){
        return view('admin.index');
    }

    //后台欢迎页
    public function welcome(){
        return view('admin.welcome');
    }

    //后台退出登录
    public function loginOut(){
        session()->flush();

        return redirect('admin/login');
    }

    //没有权限页面
    public function noaccess(){
        return view('admin/errors/noaccess');
    }
}

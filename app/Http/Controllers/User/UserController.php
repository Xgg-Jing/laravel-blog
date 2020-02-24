<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //前台首页
    public function index(){
        return view('user.index ');
    }

    //前台首页
    public function article(){
        return view('user.article ');
    }

    //前台首页
    public function diary(){
        return view('user.diary ');
    }

    //前台首页
    public function link(){
        return view('user.link ');
    }

    //前台首页
    public function message(){
        return view('user.message ');
    }

    //前台首页
    public function read(){
        return view('user.read ');
    }
}

<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use Illuminate\Support\Facades\Route;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //获取当前路由对应控制器名
        $route = Route::current()->getActionName();
//        dd($route);

        //获取当前用户拥有的权限
        $per_url = session()->get('per_url');
//        $user = User::find(session()->get('user')->user_id);
//
//        $roles = $user->role;
//
//        $per_url =[];
//        foreach($roles as $value){
//            $per = $value->permission;
//            foreach ($per as $v){
//                $per_url[] = $v->per_url;
//            }
//        }
//        //去掉重复的权限
//
//        $per_url = array_unique($per_url);
        if (in_array($route,$per_url)){
            return $next($request);

        }else{
            return redirect('noaccess');
        }
    }
}

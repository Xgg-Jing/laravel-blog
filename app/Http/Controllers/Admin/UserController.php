<?php

namespace App\Http\Controllers\Admin;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * 获取用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user =User::orderBy('user_id','asc')
            ->where(function($query) use($request){
                $username = $request->username;
                $email = $request->email;
                if (!empty($username)){
                    $query->where('user_name','like','%'.$username.'%');
                }
                if (!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })->paginate($request->input('num')?$request->input('num'):3);
//         = Role::get();

        foreach($user as $key => $value){
            $user_role = $value->role;
            $role='';
            foreach ($user_role as $v){
                $role .=$v->role_name.'|';
            }
            $roles[$value->user_id]=$role;
        }


//        $user = User::paginate(10);
        return view('admin.user.list',compact('user','request','roles'));
    }

    /**
     * 返回用户添加页面
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //1

        $role =Role::get();
        return view('admin.user.create',compact('role'));
    }

    /**
     * 执行添加操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.接收前台数据
        $input = $request->all();


        //2.验证
        if (User::where('user_name',$input['username'])->first()){

            $data = [
                'status'=>2,
                'message'=>'用户名已存在'
            ];
            return $data;
        }
        if (User::where('email',$input['email'])->first()){
            $data = [
                'status'=>3,
                'message'=>'邮箱已存在'
            ];
            return $data;

        }
        //3.保存到数据库


        $username = $input['username'];
        $email = $input['email'];
        $pass =Crypt::encrypt($input['pass']);



        $res = User::create(['user_name'=>$username,'user_pass'=>$pass,'email'=>$email]);

        //保存角色
        if (!empty($request->role_id)){
            foreach ($request->role_id as $v){
                DB::table('user_role')->insert(['user_id'=> $res->user_id ,'role_id' => $v  ]);
            }
        }
        //4.返回前台需要的值
        if ($res){
            $data=[
                'status' => 0,
                'message' => '添加成功'
            ];
        }else{
            $data=[
                'status' => 1,
                'message'=> '添加失败'
            ];
        }
//        json_encode()
        return $data;

    }

    /**
     * 显示一条用户记录
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 返回一个修改界面
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user=User::find($id);

        $role =Role::get();

        //用户拥有角色的id
        $user_role = $user->role;
        $user_roles=[];

        foreach ($user_role as $v){
            $user_roles[]=$v->id;
        }

        return view('admin.user.edit',compact('user','role','user_roles'));
    }

    /**
     * 执行修改操作
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);
        $user->user_name = $request->username;
        $user->email =$request->email;

        //删除当前用户已有角色
        DB::table('user_role')->where('user_id',$request->id)->delete();

        //添加新角色
        if (!empty($request->role_id)){
            foreach ($request->role_id as $v){
                DB::table('user_role')->insert(['user_id'=> $request->id ,'role_id' => $v  ]);
            }
        }

        if ($user->save()){
            $data=[
                'status' => 0,
                'message' => '修改成功'
            ];
        }else{
            $data=[
                'status' => 1,
                'message'=> '修改失败'
            ];
        }
        return $data;
    }

    /**
     * 执行删除操作
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (User::destroy($id)){
            $data=[
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data=[
                'status' => 1,
                'message'=> '删除失败'
            ];
        }

        return $data;
    }

    //批量删除
    public function delAll(Request $request){

        if (User::destroy($request->ids)){
            $data=[
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data=[
                'status' => 1,
                'message'=> '删除失败'
            ];
        }

        return $data;
    }

    //用户统计
    public function welcome(){


        return view('admin.user.userWelcome') ;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::paginate(10);
        foreach($role as $key => $value){
            $role_per = $value->permission;
            $per='';
            foreach ($role_per as $v){
                $per .=$v->per_name.'|';
            }
            $pers[$value->id]=$per;
        }
        return view('admin.role.list',compact('role','pers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $per = Permission::get();

        return view('admin.role.create', compact('per'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.接收前台数据
        $input = $request->all();


        //2.验证
        if (Role::where('role_name',$input['role_name'])->first()){

            $data = [
                'status'=>2,
                'message'=>'角色已存在'
            ];
            return $data;
        }

        //3.保存到数据库


        $role_name = $input['role_name'];
        $role_info = $input['role_info'];

        $res = Role::create(['role_name'=>$role_name,'role_info'=>$role_info]);

        //保存权限
        if (!empty($request->per_id)){
            foreach ($request->per_id as $v){
                DB::table('role_permission')->insert(['role_id'=> $res->id ,'permission_id' => $v  ]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role=Role::find($id);

        $per =Permission::get();

        //角色拥有权限的id
        $role_per = $role->permission;
        $role_pers=[];
        foreach ($role_per as $v){
            $role_pers[]=$v->id;
        }
        return view('admin.role.edit',compact('role','per','role_pers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        $role->role_name = $request->role_name;
        $role->role_info =$request->role_info;

        //删除当前角色已有权限
        DB::table('role_permission')->where('role_id',$request->id)->delete();

        //添加新权限
        if (!empty($request->per_id)){
            foreach ($request->per_id as $v){
                DB::table('role_permission')->insert(['role_id'=> $request->id ,'permission_id' => $v  ]);
            }
        }

        if ($role->save()){
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (Role::destroy($id)){
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

        if (Role::destroy($request->ids)){
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
}

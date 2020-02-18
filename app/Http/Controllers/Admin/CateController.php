<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cate = Category::orderBy('cate_order','asc')->paginate(15);
        $cates = [];
        foreach ($cate as $value){
            if($value->cate_pid == 0){
                $cates[] = $value;
            }
        }
        foreach($cates as $v){
            $v['childs'] =[];
            $arr = [];
            $category = Category::orderBy('cate_order','asc')->get();
            foreach($category as $vs){
                if ($vs->cate_pid == $v->cate_id){
                    $arr[]= $vs;
                }
            }
            $v['childs'] = $arr;
        }
//        $page = Category::where('cate_pid',0)->paginate(5);

        return view('admin.cate.list',compact('cates','cate','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.cate.create',compact('id'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //1.接收前台数据
        $input = $request->all();

        //2.验证
        if (Category::where('cate_name',$input['cate_name'])->first()){

            $data = [
                'status'=>2,
                'message'=>'分类已存在'
            ];
            return $data;
        }

        //3.保存到数据库


        $cate_name = $input['cate_name'];
        $cate_title = $input['cate_title'];
        $cate_order = $input['cate_order'];
        if (!empty($input['pid'])){
            $cate_pid = $input['pid'];
        }else{
            $cate_pid = 0;
        }


        $res = Category::create(['cate_name'=>$cate_name,'cate_title'=>$cate_title,'cate_order'=>$cate_order,'cate_pid'=>$cate_pid]);


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
        $cate=Category::find($id);



        //角色拥有权限的id

        return view('admin.cate.edit',compact('cate'));
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
        $cate = Category::find($id);

        $cate->cate_name = $request->cate_name;
        $cate->cate_title =$request->cate_title;
        $cate->cate_order =$request->cate_order;



        if ($cate->save()){
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

        if (Category::where('cate_id',$id)->delete()){
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
        if (Category::destroy($request->ids)){
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

    //分类排序
    public function order(Request $request){
        $input = $request->all();

        $cate = Category::find($input['cate_id']);

        $res = $cate->update(['cate_order' => $input['cate_order']]);
        if ($res){
            $data = [
                'status' => 0,
                'msg' => '修改排序成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '修改排序失败'
            ];
        }

        return $data;
    }
}

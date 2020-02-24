<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //定义一个变量，存放所有的文章记录
        $arts = [];
        $arts = Article::get();
//        $listkey = 'LIST:ARTICLE';
//        $hashkey = 'HASH:ARTICLE:';
////        redis中存在要取的文章
//        if(Redis::exists($listkey)){
//            //存放所有要获取文章的id
//            $lists = Redis::lrange($listkey,0,-1);
//
//            foreach ($lists as $k=>$v){
//                $arts[] = Redis::hgetall($hashkey.$v);
//            }
//
//        }else{
////            1. 链接mysql数据库，获取需要的数据
//            $arts = Article::get()->toArray();
//
////            2. 将数据存入redis
//            foreach ($arts as $k=>$v){
//                //将文章的id添加到listkey变量中
//                Redis::rpush($listkey,$v['art_id']);
////                将文章添加到hashkey变量中
//                Redis::hmset($hashkey.$v['art_id'],$v);
//            }
////            3. 返回数据给客户端
//        }
//


        return view('admin.article.list',compact('arts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates = Category::all();

        return view('admin.article.add',compact('cates'));
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
        dd($request->all());
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
        //
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
        //
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
    }

    //图片上传
    public function upload(Request $request){

        //获取上传文件
       $file =  $request->file('art_thumb_f');

       //判断上传文件是否成功
        if (!$file->isValid()){
            return response()->json(['status' => 1, 'msg' => '无效上传文件']);
        }
        //判断文件大小不能超过1M
        $file_size = $file->getClientSize();

        if ( $file_size > 1024*1024) {
            return response()->json(['status' => 2, 'msg' => '请注意上传文件不能超过1M']);

        }
        //获取文件拓展名
        $ext = $file->getClientOriginalExtension();

        //建上传当天文件夹
        $public_dir = sprintf('/upload/%s/%s/', 'images', date('Y-m-d') );
        $upload_dir = public_path() . $public_dir;

        if( !file_exists($upload_dir) ) {
            mkdir($upload_dir, 0777, true);
        }

        //新文件名
        $newfile = md5(time().rand(1000,9999)).'.'.$ext;

        //文件上传指定路径
//        $upload_dir = public_path() . $public_dir;

        //将文件移动至指定目录
//        if (!$file->move($path,$newfile)){
////            return response()->json(['status' => 1, 'msg' => '文件保存失败']);
////        }
        //image图片处理组件
        $res = Image::make($file)->resize(100,100)->save($upload_dir.'/'.$newfile);

        if ($res){
            //文件上传成功
            return response()->json(['status' => 0, 'msg' => '文件上传成功', 'img' =>$public_dir.$newfile]);
        }else{
            return response()->json(['status' => 1, 'msg' => '文件保存失败']);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Org\code\Code;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //跳转登录页面
    public function login(){

        return view('admin.login');
    }
    //验证码1生成
    public function code(){
        $code = new Code();

        return $code->make();
    }
    // 验证码2生成
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = strtolower($builder->getPhrase());
        // 把内容存入session
        \Session::flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }
    //登录操作
    public function doLogin(Request $request){
        //1.接受表单数据
        $input=$request->except('_token');

        //2.进行表单验证
        $rule=[
            'username' => 'required|between:4,18',
            'password' => 'required|between:4,18|alpha_dash',

        ];
        $msg=[
            'username.required' => '用户必须输入',
            'username.between' => '用户名长度必须在4-18位之间',
            'password.required' => '密码必须输入',
            'password.between' => '密码长度必须在4-18位之间',
            'password.required' => '密码必须是数字字母下划线',
        ];
        $validator = Validator::make($input, $rule,$msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
        //3.验证是否有此用户(验证码、用户名、密码)
        $user = User::where('user_name',$input['username'])->first();
         if(!$user){
            return redirect('admin/login')->with('errors','用户名错误！');
        }

        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码错误！');
        }

//        if ($data['captcha'] != \Session::get('code')) {
//            return back()
//                ->withErrors('验证码错误!');
//        }
        if ($input['code'] != session()->get('code')){
            return redirect('admin/login')->with('errors','验证码错误！');

        }

        //4.保存用户信息到session中
        session()->put('user',$user);


        //5.跳转到后台首页
        return redirect('admin/index');

    }
    public function jiami(){
//        //1.md5加密
//        $str = '123456';
//        return md5($str);
//
//        //2.哈希加密
//        $str = '123456';
//        $hash = Hash::make($str);
//        if (Hash::check($str,$hash)){
//            return '密码正确';
//        }

        //3.crypt加密
        $str = '123456';
        $crypt_str = 'eyJpdiI6Im9neE5DTEpBVk9wcWF3STlhVUx6R3c9PSIsInZhbHVlIjoiYnZcL0U2UFBpcmozdDlhTHVlTDRZZmc9PSIsIm1hYyI6ImZhZmYwMmVjZjM3OGIyODIxZDUyM2ViYThiOGQ0NmM2YzAwNTVjZTZlODcwZGMzMWMzZmNjNGE0OThmOGIwZDcifQ';
//        $hash = Crypt::encrypt($str);
//        return $hash;
        if (Crypt::decrypt($crypt_str) == $str){
            return '密码正确！';
        }
    }
}

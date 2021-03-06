<!doctype html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>smd后台登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    @include('admin.public.scripts')
    @include('admin.public.styles')
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
    <div class="message">smd后台管理登录</div>
    <div id="darkbannerwrap"></div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @if(is_object($errors))
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @else
                    <li>{{ $errors }}</li>
                @endif
            </ul>
        </div>
    @endif
    <form method="post" class="layui-form" action="{{url('admin/doLogin')}}">
        {{csrf_field()}}
        <input name="username" placeholder="用户名" type="text" lay-verify="required" class="layui-input">
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
        <hr class="hr15">


        <input name="code" lay-verify="required" placeholder="验证码" type="text" class="layui-input"
               style="width: 160px;height: 40px;float: left;">
        {{--        验证码1--}}
        {{--        <img  src="{{url('admin/code')}}" style="width: 100px;height: 40px;float: right;" onclick="this.src='{{url('admin/code')}}?'+Math.random()">--}}
        {{--        laravel验证码2--}}
        <a onclick="javascript:re_captcha();" style="float: right">
            <img src="{{ URL('admin/code/captcha/1') }}" id="127ddf0de5a04167a9e427d883690ff6">
        </a>
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20">
    </form>
</div>

<script>

    $(function () {
        layui.use('form', function () {
            var form = layui.form;
            // layer.msg('玩命卖萌中', function(){
            //   //关闭后的操作
            //   });
            //监听提交
            form.on('submit(login)', function (data) {
                // alert(888)

            });
        });
    })
</script>
{{--验证码2--}}
{{--点击切换验证码2--}}
<script type="text/javascript">
    function re_captcha() {
        $url = "{{ URL('admin/code/captcha') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('127ddf0de5a04167a9e427d883690ff6').src = $url;
    }
</script>
<!-- 底部结束 -->
</body>
</html>
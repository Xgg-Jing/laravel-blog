<!DOCTYPE html>
<html class="x-admin-sm">
<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    @include('admin.public.scripts')
        @include('admin.public.styles')
        <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
          </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
       onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5" method="get" action="{{url('admin/user')}}">
                        <div class="layui-inline layui-show-xs-block">
                            <select name="num" lay-filter="aihao">
                                <option value=""></option>
                                <option value="3" @if($request->num == 3) selected @endif>3</option>
                                <option value="5" @if($request->num == 5) selected @endif>5</option>

                            </select>
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input class="layui-input" autocomplete="off" placeholder="请输入用户名" name="username"
                                   class="layui-input" value="{{$request->username}}">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="email" placeholder="请输入邮箱" autocomplete="off" class="layui-input"
                                   value="{{$request->email}}">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn" lay-submit="" lay-filter="sreach"><i
                                        class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除
                    </button>
                    <button class="layui-btn" onclick="xadmin.open('添加用户','{{url('admin/user/create')}}',600,400)"><i
                                class="layui-icon"></i>添加
                    </button>
                </div>
                <div class="layui-card-body layui-table-body layui-table-main">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                            </th>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>角色</th>

                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($user as $v)
                            <tr>
                                <td>
                                    <input type="checkbox" name="id" value="{{$v->user_id}}" lay-skin="primary">
                                </td>
                                <td>{{$v->user_id}}</td>
                                <td>{{$v->user_name}}</td>
                                <td>{{$v->email}}</td>

                                @foreach($roles as $key => $value)
                                    @if($v->user_id == $key)
                                        <td>{{$value}}</td>

                                    @endif
                                @endforeach
                                <td class="td-status">
                                    <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                                <td class="td-manage">

                                    <a title="编辑"
                                       onclick="xadmin.open('编辑','{{url('admin/user/'.$v->user_id.'/edit')}}',600,400)"
                                       href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                    </a>

                                    <a title="删除" onclick="member_del(this,'{{$v->user_id}}')" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="layui-card-body ">
                    <div class="page">
                        <div>
                            {{ $user->appends($request->all())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    layui.use(['laydate', 'form'], function () {
        var laydate = layui.laydate;
        var form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function (data) {

            if (data.elem.checked) {
                $('tbody input').prop('checked', true);
            } else {
                $('tbody input').prop('checked', false);
            }
            form.render('checkbox');
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });


    });

    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要停用吗？', function (index) {

            if ($(obj).attr('title') == '启用') {

                //发异步把用户状态进行更改
                $(obj).attr('title', '停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!', {icon: 5, time: 1000});

            } else {
                $(obj).attr('title', '启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!', {icon: 5, time: 1000});
            }

        });
    }

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            //发异步删除数据
            $.post('{{url('admin/user')}}' + '/' + id, {
                "_method": "delete",
                "_token": "{{csrf_token()}}"
            }, function (data) {
                if (data.status == 0) {

                    layer.msg(data.message, {icon: 6, time: 1000}, function () {
                        location.reload(true)
                    });
                } else {
                    layer.msg(data.message, {icon: 6})
                }
            });
            // $(obj).parents("tr").remove();
            // layer.msg('已删除!',{icon:1,time:1000});
        });
    }


    function delAll(argument) {
        var ids = [];

        // 获取选中的id 
        $('tbody input').each(function (index, el) {
            if ($(this).prop('checked')) {
                ids.push($(this).val())
            }
        });

        layer.confirm('确认要删除吗？', function (index) {
            //捉到所有被选中的，发异步进行删除
            $.post('{{url('admin/user/del')}}', {"ids": ids, "_token": "{{csrf_token()}}"}, function (data) {
                if (data.status == 0) {
                    layer.msg(data.message, {icon: 6, time: 1000}, function () {
                        location.reload(true)
                    });
                } else {
                    layer.msg(data.message, {icon: 5, time: 1000})
                }
            });
            // layer.msg('删除成功', {icon: 1});
            // $(".layui-form-checked").not('.header').parents('tr').remove();
        });
    }
</script>
</html>
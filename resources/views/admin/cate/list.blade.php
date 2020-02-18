<!DOCTYPE html>
<html class="x-admin-sm">

<head>
	<meta charset="UTF-8">
	<title>欢迎页面-X-admin2.2</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
@include('admin.public.scripts')
@include('admin.public.styles')
	<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
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
	<a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
		<i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
	</a>
</div>
<div class="layui-fluid">
	<div class="layui-row layui-col-space15">
		<div class="layui-col-md12">
			<div class="layui-card">
				<div class="layui-card-body ">
					<form class="layui-form layui-col-space5" >

						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="分类名" name="cate_name"></div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="分类标题" name="cate_title"></div>
						<div class="layui-input-inline layui-show-xs-block">
							<input class="layui-input" placeholder="排序" name="cate_order"></div>

						<div class="layui-input-inline layui-show-xs-block">
							<button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
						</div>
					</form>
					<hr>
					<blockquote class="layui-elem-quote">每个tr 上有两个属性 cate-id='1' 当前分类id fid='0' 父级id ,顶级分类为 0，有子分类的前面加收缩图标<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote>
				</div>
				<div class="layui-card-header">
					<button class="layui-btn layui-btn-danger" onclick="delAll()">
						<i class="layui-icon"></i>批量删除</button>
				</div>
				<div class="layui-card-body ">
					<table class="layui-table layui-form">
						<thead>
						<tr>
							<th width="20">
								<input type="checkbox" name="" lay-skin="primary">
							</th>
							<th width="70">ID</th>
							<th>分类名</th>
							<th>分类标题</th>
							<th width="50">排序</th>
							<th width="80">状态</th>
							<th width="250">操作</th>
						</thead>
						<tbody class="x-cate">
						@foreach($cates as $v)
						<tr cate-id='{{$v->cate_id}}' fid='0' >
							<td>
								<input type="checkbox" name="del" value="{{$v->cate_id}}" lay-skin="primary">
							</td>
							<td>{{$v->cate_id}}</td>
							<td>
								<i class="layui-icon x-show" status='true'>&#xe623;</i>
								{{$v->cate_name}}
							</td>
							<td>{{$v->cate_title}}</td>
							<td><input type="text" onchange="changeOrder(this,{{$v->cate_id}})" class="layui-input x-sort" name="cate_order" value="{{$v->cate_order}}"></td>
							<td>
								<input type="checkbox" name="switch"  lay-text="开启|停用"  checked="" lay-skin="switch">
							</td>
							<td class="td-manage">
								<button class="layui-btn layui-btn layui-btn-xs"  onclick="xadmin.open('编辑','{{url('admin/cate/'.$v->cate_id.'/edit')}}')" ><i class="layui-icon">&#xe642;</i>编辑</button>
								<button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="xadmin.open('编辑','{{url('admin/cate/create/'.$v->cate_id)}}')" ><i class="layui-icon">&#xe642;</i>添加子栏目</button>
								<button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del_p(this,'{{$v->cate_id}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
							</td>
						</tr>
							@foreach($v->childs as $k)
								<tr cate-id='{{$k->cate_id}}' fid='{{$v->cate_id}}' >
									<td>
										<input type="checkbox" name="del " value="{{$k->cate_id}}" lay-skin="primary">
									</td>
									<td>{{$k->cate_id}}</td>
									<td>


										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										├
										{{$k->cate_name}}
									</td>
									<td>{{$k->cate_title}}</td>
									<td><input type="text" class="layui-input x-sort" onchange="changeOrder(this,{{$k->cate_id}})" name="cate_order" value="{{$k->cate_order}}"></td>
									<td>
										<input type="checkbox" name="switch"  lay-text="开启|停用"  checked="" lay-skin="switch">
									</td>
									<td class="td-manage">
										<button class="layui-btn layui-btn layui-btn-xs"  onclick="xadmin.open('编辑','{{url('admin/cate/'.$v->cate_id.'/edit')}}')" ><i class="layui-icon">&#xe642;</i>编辑</button>
										<button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'{{$k->cate_id}}')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
									</td>
								</tr>
							@endforeach
						@endforeach

						</tbody>
					</table>
				</div>
				<div class="layui-card-body ">
					<div class="page">
						<div>
							{{ $cate->links() }}

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	layui.use(['form', 'layer', 'jquery'], function(data){

		$ = layui.jquery;
		var form = layui.form,
				layer = layui.layer;
		//监听提交

		form.on('submit(sreach)',
				function (data) {

					//发异步，把数据提交给php

					$.ajax({
						url: '{{url('admin/cate')}}',
						type: 'post',
						dataType: 'json',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: data.field,
						success: function (data) {

							if (data.status == 0) {
								layer.alert(data.message, {icon: 6}, function () {
									location.reload(true);
								})
							} else {
								layer.alert(data.message, {icon: 5})
							}
						}
					});
					// layer.alert("增加成功", {
					//     icon: 6
					// },
					// function() {
					//     //关闭当前frame
					//     xadmin.close();
					//
					//     // 可以对父窗口进行刷新
					//     xadmin.father_reload();
					// });
					return false;
				});

	});

	/*父类-删除*/
	function member_del_p(obj,id){
		layer.confirm('确认要删除吗？',function(index){
			//发异步删除数据
			$.post('{{url('admin/cate')}}' + '/' + id, {
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
		});
	}
	/*子类-删除*/
	function member_del(obj,id){
		layer.confirm('确认要删除吗？',function(index){
			//发异步删除数据
			$.post('{{url('admin/cate')}}' + '/' + id, {
				"_method": "delete",
				"_token": "{{csrf_token()}}"
			}, function (data) {
				if (data.status == 0) {

					layer.msg(data.message, {icon: 6, time: 1000}, function () {
						location.reload();
					});
				} else {
					layer.msg(data.message, {icon: 6})
				}
			});
		});
	}
	function delAll(argument) {
		var ids = [];

		// 获取选中的id
		$("input[name='del']").each(function (index, el) {
			if ($(this).prop('checked')) {
				ids.push($(this).val())
			}
		});

		layer.confirm('确认要删除吗？', function (index) {
			//捉到所有被选中的，发异步进行删除
			$.post('{{url('admin/cate/del')}}', {"ids": ids, "_token": "{{csrf_token()}}"}, function (data) {
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

	//排序
	function changeOrder(obj,id){

		// 获取当前文本框的值（修改后的排序值）
		var order_id = $(obj).val();
		console.log(order_id);

		$.post('{{url('admin/cate/order')}}',{'_token':"{{csrf_token()}}","cate_id":id,"cate_order":order_id},function(data){
			// console.log(data);
			if(data.status == 0){
				layer.msg(data.msg,{icon:6},function(){
					location.reload();
				});
			}else{
				layer.msg(data.msg,{icon:5});
			}
		});
	}

	// 分类展开收起的分类的逻辑
	//
	$(function(){
		$("tbody.x-cate tr[fid!='0']").hide();
		// 栏目多级显示效果
		$('.x-show').click(function () {
			if($(this).attr('status')=='true'){
				$(this).html('&#xe625;');
				$(this).attr('status','false');
				var cateId = $(this).parents('tr').attr('cate-id');
				$("tbody tr[fid="+cateId+"]").show();
			}else{
				cateIds = [];
				$(this).html('&#xe623;');
				$(this).attr('status','true');
				 var cateId = $(this).parents('tr').attr('cate-id');
				getCateId(cateId);
				for (var i in cateIds) {
					$("tbody tr[cate-id="+cateIds[i]+"]").hide().find('.x-show').html('&#xe623;').attr('status','true');
				}
			}
		})
	});

	var cateIds = [];
	function getCateId(cateId) {
		$("tbody tr[fid="+cateId+"]").each(function(index, el) {
			id = $(el).attr('cate-id');
			cateIds.push(id);
			getCateId(id);
		});
	}

</script>
</body>
</html>

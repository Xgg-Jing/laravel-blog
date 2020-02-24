<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.public.scripts')
    @include('admin.public.styles')
</head>

<body>
<div class="x-body">
    <form class="layui-form" id="art_form" >
                    {{ csrf_field() }}
        <div class="layui-form-item">
            <label for="L_email" class="layui-form-label">
                <span class="x-red">*</span>分类
            </label>
            <div class="layui-input-inline">
                <select name="cate_id">
                    {{--<option value="0">==顶级分类==</option>--}}
                    @foreach($cates as $k=>$v)
                        <option value="{{ $v->cate_id }}">{{ $v->cate_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>

        <div class="layui-form-item">
            <label for="L_art_title" class="layui-form-label">
                <span class="x-red">*</span>文章标题
            </label>
            <div class="layui-input-block">
                {{csrf_field()}}
                <input type="text" id="L_art_title" name="art_title" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_art_editor" class="layui-form-label">
                <span class="x-red">*</span>编辑
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_art_editor" name="art_editor" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">缩略图</label>
            <div class="layui-input-block layui-upload">
                <input type="text" name="art_thumb" hidden value="">
                <input type="file" hidden id="input_id" class="hidden" onchange="return upload('input_id','images','preview_id');" name="art_thumb_f" >
                <img id="preview_id" src="/upload/tianjia.jfif" onclick="$('#input_id').click()"
                     style="height: 150px">
            </div>
        </div>



        <div class="layui-form-item">
            <label for="L_art_tag" class="layui-form-label">
                <span class="x-red">*</span>关键词
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_art_tag" name="art_tag" required=""
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_art_tag" class="layui-form-label">
                <span class="x-red">*</span>描述
            </label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea" name="art_description"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_art_tag" class="layui-form-label">
                <span class="x-red">*</span>内容
            </label>
            {{--<div class="layui-input-block">--}}
            {{--<div class="layui-tab">--}}
            {{--<ul class="layui-tab-title">--}}
            {{--<li class="layui-this">输入markdown语法内容</li>--}}
            {{--<li id="previewBtn">预览Html语法的内容</li>--}}

            {{--</ul>--}}
            {{--<div class="layui-tab-content">--}}
            {{--<div class="layui-tab-item layui-show">--}}
            {{--<textarea id="z-textarea" name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>--}}
            {{--</div>--}}
            {{--<div class="layui-tab-item">--}}
            {{--<textarea id="z-textarea-preview" name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>--}}
            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}
            <div class="layui-input-block">
                <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
                <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>


                <script id="editor" type="text/plain" name="art_content" style="width:600px;height:300px;"></script>
                <script type="text/javascript">
                    //实例化编辑器
                    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                    var ue = UE.getEditor('editor');

                </script>

            </div>
        </div>

</div>
<div class="layui-form-item">
    <label for="L_repass" class="layui-form-label">
    </label>
    <button class="layui-btn" lay-filter="add" lay-submit="">
        增加
    </button>
</div>
</form>
</div>
</body>
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    });

    //Markdown AJAX
    $('#previewBtn').click(function () {
        $.ajax({
            url: "/admin/article/pre_mk",
            type: "post",
            data: {
                cont: $('#z-textarea').val()
            },
            success: function (res) {
                $('#z-textarea-preview').html(res);
            },
            error: function (err) {
                console.log(err.responseText);
            }
        });
    })


</script>
<script>
    function upload(){
        var formData = new FormData($('#art_form')[0]);
        console.log('ss');
        var obj = this;
        $.ajax({
            url: '/admin/article/upload',
            type: 'post',
            data: formData,
            // 因为data值是FormData对象，不需要对数据做处理
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status == 0) {
                    // 如果成功
                    {{--$('#art_thumb_img').attr('src', '{{ env('ALIOSS_DOMAIN')  }}'+data['ResultData']);--}}
                    {{--$('#art_thumb_img').attr('src', '{{ env('QINIU_DOMAIN')  }}'+data['ResultData']);--}}

                    $('#preview_id').attr('src', data.img);
                    $("input[name='art_thumb']").val(data.img);

                    $(obj).off('change');
                } else {
                    // 如果失败
                    layer.msg(data.msg, {icon: 5})
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                var number = XMLHttpRequest.status;
                var info = "错误号" + number + "文件上传失败!";
                // 将菊花换成原图
                // $('#pic').attr('src', '/file.png');
                alert(info);
            },
            async: true
        });
    }
    layui.use(['form', 'layer', 'upload', 'element'], function () {
        $ = layui.jquery;
        var form = layui.form
            , layer = layui.layer;
        var upload = layui.upload;
        var element = layui.element;





        //监听提交
        form.on('submit(add)', function (data) {


            console.log(ue.getContent());
           var art_content = ue.getContent();
            $.ajax({
                url: '{{url('admin/article')}}',
                type: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data.field,
                success: function (data) {

                    if (data.status == 0) {
                        layer.msg(data.message, {icon: 6}, function () {
                            parent.location.reload(true);
                        })
                    } else {
                        layer.msg(data.message, {icon: 5})
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
</script>

</html>
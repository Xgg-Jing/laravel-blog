<div class="left-nav">
    <div id="side-nav">
        <ul id="nav">
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="会员管理">&#xe6b8;</i>
                    <cite>会员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('统计页面','welcome1.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>统计页面</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('会员列表(静态表格)','member-list.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表(静态表格)</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('会员列表(动态表格)','member-list1.html',true)">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员列表(动态表格)</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('会员删除','member-del.html')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>会员删除</cite></a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont">&#xe70b;</i>
                            <cite>会员管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i></a>
                        <ul class="sub-menu">
                            <li>
                                <a onclick="xadmin.add_tab('会员删除','member-del.html')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>会员删除</cite></a>
                            </li>
                            <li>
                                <a onclick="xadmin.add_tab('等级管理','member-list1.html')">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>等级管理</cite></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="分类管理">&#xe723;</i>
                    <cite>分类管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('多级分类','{{url('admin/cate')}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>多级分类</cite></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="文章管理">&#xe723;</i>
                    <cite>文章管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('文章列表','{{url('admin/article')}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>文章列表</cite></a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="javascript:;">
                    <i class="iconfont left-nav-li" lay-tips="管理员管理">&#xe726;</i>
                    <cite>管理员管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i></a>
                <ul class="sub-menu">
                    <li>
                        <a onclick="xadmin.add_tab('管理员列表','{{url('admin/user')}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>管理员列表</cite></a>
                    </li>
                    <li>
                        <a onclick="xadmin.add_tab('角色管理','{{url('admin/role')}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>角色管理</cite></a>
                    </li>

                    <li>
                        <a onclick="xadmin.add_tab('权限管理','{{url('admin/permission')}}')">
                            <i class="iconfont">&#xe6a7;</i>
                            <cite>权限管理</cite></a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
<!-- <div class="x-slide_left"></div> -->
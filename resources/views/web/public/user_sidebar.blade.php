
<div class="navbar-default sidebar" role="navigation" style="margin-top: 0;">
    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="side-menu">

            <li>
                <a href="{{ route('web.project.search') }}" class="{{ active('web.project.search') }}"><i class="fa fa-search fa-fw"></i> 搜索项目</a>
            </li>

            <li>
                <a href="{{ route('web.project.applyList') }}" class="{{ active('web.project.applyList') }}"><i class="fa fa-bell-o fa-fw"></i> 申请管理</a>
            </li>

<!--            <li>-->
<!--                <a href="{{url('notice')}}"><i class="fa fa-bell-o fa-fw"></i> 消息中心</a>-->
<!--            </li>-->

            <li>
                <a href="{{ route('web.loginHistory') }}" class="{{ active('web.loginHistory') }}"><i class="fa fa-history fa-fw"></i> 登录历史</a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
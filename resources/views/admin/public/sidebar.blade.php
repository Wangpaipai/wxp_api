<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('admin.index') }}" class="{{ active('admin.index') }}"><i class="fa fa-home fa-fw "></i> 管理主页</a>
            </li>
            <li>
                <a href="{{ route('admin.project') }}" class="{{ active('admin.project') }}"><i class="fa fa-folder-open fa-fw "></i> 项目管理</a>
            </li>
            <li>
                <a href="{{ route('admin.member') }}" class="{{ active('admin.member') }}"><i class="fa fa-user fa-fw"></i> 用户管理</a>
            </li>
            <li>
                <a href="{{ route('admin.history') }}" class="{{ active('admin.history') }}"><i class="fa fa-history fa-fw"></i> 登录历史</a>
            </li>
        </ul>
    </div>
</div>
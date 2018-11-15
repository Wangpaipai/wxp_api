<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="javascript:void(0);">
{{--            {{if $project}}当前项目:{{$project.title}}{{else}}{{get_config('name')}}{{/if}}--}}
            王小牌API管理系统
        </a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">

        <li class="dropdown">
            <a class="dropdown-toggle" href="{{url('project/select')}}">
                <i class="fa fa fa-random fa-fw"></i> 切换项目
            </a>
        </li>

        <!-- /.dropdown -->
        <li class="dropdown js_notifyDropdown">

{{--            {{include_file name="notify/load"}}--}}

            <!-- /.dropdown-alerts -->
        </li>

        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{ $user->name }}
                <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href=""><i class="fa fa-search fa-fw"></i> 搜索项目</a>
                </li>

                <li><a href="#" data-toggle="modal" data-target="#js_settingProfileModal"><i class="fa fa-user fa-fw"></i> 个人设置</a>
                </li>
                @if($user->is_admin)
                    <li><a href=""><i class="fa fa-gear fa-fw"></i> 管理中心</a></li>
                @endif
                <li class="divider"></li>
                <li><a class="js_logoutBtn" href="{{ route('web.loginOut') }}"><i class="fa fa-sign-out fa-fw"></i> 退出登录</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    {{--{{if $sidebar}}--}}

    {{--{{include_file name="public/{{$sidebar}}"}}--}}

    {{--{{/if}}--}}

    <!-- /.navbar-static-side -->
</nav>
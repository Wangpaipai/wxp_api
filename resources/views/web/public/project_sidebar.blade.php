<div class="navbar-default sidebar" role="navigation" style="margin-top: 0">
    <div class="sidebar-nav navbar-collapse">

        <ul class="nav" id="side-menu">

            <li>
                <a href="{{ route('web.project.api.home',['id' => $project->id]) }}"><i class="fa fa-home fa-fw"></i> 项目主页</a>
            </li>

            @foreach($menu as $value)
            <li class="module-item js_moduleItem" data-id="{{ $value['id'] }}">
                <a href="javascript:void(0);"><i class="fa fa-fw fa-folder-open"></i>
                    {{ $value['name'] }}

                    <span class="fa fa-fw arrow"></span>
                    @if($group['is_del'])
                        <span class="fa hidden-xs fa-fw fa-trash-o js_deleteModuleBtn" data-id="{{ $value['id'] }}" title="删除模块"></span>
                    @endif
                    @if($group['is_update'])
                        <span class="fa hidden-xs fa-fw fa-plus js_addApiBtn" data-id="{{ $value['id'] }}" title="添加接口"></span>
                        <span class="fa hidden-xs fa-fw fa-pencil  js_addModuleBtn" data-id="{{ $value['id'] }}" title="编辑模块"></span>
                    @endif
                </a>
                <ul class="nav nav-second-level collapse" id="api-menu-{{ $value['id'] }}">
                    @foreach($value['api'] as $v)
                    <li class="api-item js_apiItem" data-id="{{ $v['api_id'] }}">
                        <a href="" title="点击查看接口详情">
                        <i class="fa fa-fw fa-files-o"></i>{{$api['title']}}
                        <i class="fa fa-fw fa-eye pull-right"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>
                <!-- /.nav-second-level -->
            </li>
            @endforeach
            <li>
                <a class="js_addModuleBtn hidden-xs" data-id="{{ $project->id }}" data-title="添加模块" href="javascript:void(0);"><i class="fa fa-fw fa-plus"></i> 添加模块</a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>

<!-- 添加/编辑模块模态框 -->
<div class="modal fade" id="js_addModuleModal" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加模块</h4>
            </div>
            <div class="modal-body">

                {{--<iframe id="js_addModuleIframe" style="min-height: 180px;" src="{{url('module/add')}}"></iframe>--}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary js_submit">提交</button>
            </div>

        </div>
    </div>

</div>

<!-- 添加接口模态框 -->
<div class="modal fade" id="js_addApiModal" tabindex="1" role="dialog">
    <div class="modal-dialog" style="width: 700px;" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">添加接口</h4>
            </div>
            <div class="modal-body">

{{--                <iframe id="js_addApiIframe" style="min-height: 380px;" src="{{url('api/add')}}"></iframe>--}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary js_submit">提交</button>
            </div>

        </div>

    </div>

</div>

<!-- 删除模块模态框 -->
<div class="modal fade" id="js_deleteModuleModal" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document">
        <form role="form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">确定删除此模块吗？</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-dismissable alert-warning">
                        <i class="fa fa-fw fa-info-circle"></i>
                        模块删除后，该模块下所有接口也将被立刻删除，不可恢复，请谨慎操作！
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" class="form-control">
                        <input type="text" name='password' class="form-control" placeholder="重要操作，请输入登录密码" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-danger js_submit">删除</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>


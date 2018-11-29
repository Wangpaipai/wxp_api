@extends('web.public.app')
@section('title', '接口详情')

@section('css')
    <link href="{{ asset('static/plugins/jsonFormat/css.css') }}" rel="stylesheet" type="text/css">
    <style>
        @media(min-width:768px) {

            .sidebar {
                z-index: 1;
                position: absolute;
                width: 200px;
                margin-top: 51px;
            }
            #page-wrapper {
                position: inherit;
                margin: 0 0 0 200px;
                padding: 0 30px;
                border-left: 1px solid #e7e7e7;
            }
        }
    </style>
@endsection

@section('content')

    @include('web.public.nav')
    @include('web.public.project_sidebar')
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1>接口主页 </h1>
                        <div class="opt-btn">
                            @if($group['is_update'])
                                <a href="{{ route('web.project.api.edit',['id' => $api->id,'project' => $project->id]) }}" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i>编辑</a>
                            @endif
                            @if($group['is_del'])
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger js_deleteApiBtn" data-id="{{ $api->id }}"><i class="fa fa-fw fa-times"></i>删除</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            接口详情
                        </div>
                        <div class="panel-body">
                            <p class="text-muted"><label>接口名称：</label>{{ $api->title }}</p>
                            <p class="text-muted"><label>请求类型：</label>{{ $api->method }}</p>
                            <p class="text-muted"><label>接口描述：</label>{{ $api->brief }}</p>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            接口地址
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">

                                    <tbody>
                                    @foreach($project->param as $value)
                                    <tr>
                                        <td style="width: 20%;">{{ $value['title'] }}({{ $value['name'] }})</td>
                                        <td style="width: 50%;"><code>{{ $value['url'] }}{{ $api->url }}</code></td>
                                        <td style="width: 15%;">
                                            <button type="button" data-clipboard-text="{{ $value['url'] }}{{ $api->url }}" class="btn btn-xs btn-success js_copyUrl"><i class="fa fa-fw fa-copy"></i>复制链接</button>
                                        </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>

                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Header参数
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="success">
                                        <th>字段键</th>
                                        <th>字段值</th>
                                        <th style="width: 33%">备注说明</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($api->header)
                                        @foreach(unserialize($api->header) as $value)
                                        <tr>
                                            <td>{{ $value['key'] ?? '' }}</td>
                                            <td>{{ $value['value'] ?? '' }}</td>
                                            <td>{{ $value['remark'] ?? '' }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            请求参数
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="success">
                                        <th>字段名</th>
                                        <th>字段含义</th>
                                        <th>字段类型</th>
                                        <th>是否必填</th>
                                        <th>默认值</th>
                                        <th style="width: 20%">备注说明</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($api->param)
                                        @foreach(unserialize($api->param) as $value)
                                        <tr>
                                            <td>{{ $value['name'] ?? '' }}</td>
                                            <td>{{ $value['brief'] ?? '' }}</td>
                                            <td>{{ $value['type'] ?? '' }}</td>
                                            <td>{{ $value['must'] ?? '' }}</td>
                                            <td>{{ $value['default'] ?? '' }}</td>
                                            <td>{{ $value['remark'] ?? '' }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            响应参数
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="success">
                                        <th>字段名</th>
                                        <th>字段含义</th>
                                        <th>字段类型</th>
                                        <th style="width: 25%">备注说明</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($api->response)
                                        @foreach(unserialize($api->response) as $value)
                                            <tr>
                                                <td>{{ $value['name'] }}</td>
                                                <td>{{ $value['brief'] ?? '' }}</td>
                                                <td>{{ $value['type'] ?? '' }}</td>
                                                <td>{{ $value['remark'] ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="panel-json">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                返回示例
                            </div>
                            <div class="panel-body">
                                <div class="hidden json-data">{{ $api->case }}</div>
                                <div class="json-box"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    @include('web.public.record')
                    <!-- /.col-lg-12 -->
                </div>
            </div>

        </div>
        <!-- /#page-wrapper -->

        <!-- 删除接口模态框 -->
        <div class="modal fade" id="js_deleteApiModal" tabindex="2" role="dialog">
            <div class="modal-dialog" role="document">
                <form id="js_deleteApiForm" role="form" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">确定删除此接口吗？</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-dismissable alert-warning">
                                <i class="fa fa-fw fa-info-circle"></i>
                                接口删除后，该项目下所有字段将被立刻删除，不可恢复，请谨慎操作！
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" id="api-id" class="form-control">
                                <input type="hidden" name="project" id="project" class="form-control" value="{{ $project->id }}">
                                <input type="password" name='password' class="form-control" placeholder="重要操作，请输入登录密码" id="pwd">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-danger delete">删除</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /#wrapper -->
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('static/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('static/plugins/jsonFormat/js.js') }}"></script>
    <script>
        $(function () {
            // 格式化json
            jsonFormat();

            // 吐司提示
            $('[data-toggle="tooltip"]').tooltip();

        });

        $('.delete').click(function(){
            if(!$('#api-id').val()){
                return layer.msg('接口不存在',{icon:0,time:2000});
            }

            if(!$('#project').val()){
                return layer.msg('项目不存在',{icon:0,time:2000});
            }
            if(!$('#pwd').val()){
                return layer.msg('请输入密码',{icon:0,time:2000});
            }
            var data = $('#js_deleteApiForm').serialize();
            $.ajax({
                type:'GET',
                dataType:'json',
                url:'{{ route('web.project.api.delete') }}',
                data:data,
                success:function(date){
                    if(date.status){
                        location.href = '{{ route('web.project.api.home',['id' => $project->id]) }}';
                    }else{
                        layer.msg(date.msg,{icon:2,time:2000});
                    }
                }
            })
        });

        // 删除接口
        $(document).delegate('.js_deleteApiBtn', 'click',function(){
            var id = $(this).data('id');

            if(id <= 0){
                alert('请选择要删除的模块', 1000);
            }

            $('#js_deleteApiModal input[name=id]').val(id);

            $('#js_deleteApiModal').modal('show');
        });

        // 复制链接
        var clipboard = new Clipboard('.js_copyUrl');
        clipboard.on('success', function(e) {
            alert('地址复制成功', 1000);
            e.clearSelection();
        });
        clipboard.on('error', function() {
            alert('地址复制失败，请手动复制', 3000);
        });

        var height = window.innerHeight;
        var width = window.innerWidth;
        if(width > 750){
            $('#wrapper').css({
                height:height - 60,
                overflow: 'auto'
            });
        }
    </script>
@endsection
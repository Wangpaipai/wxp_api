@extends('web.public.app')
@section('title', '选择项目')

@section('css')
    <style>
        .panel-body {
            height: 80px;
            overflow: hidden;
        }

        .project-add,.project-search {
            height: 180px;
            overflow: hidden;
            text-align:center;
            line-height:140px;
            font-size: 36px;
        }

        .panel:hover  {
            background-color:#EFEFEF;
            cursor: pointer;
            solid;background:#fff;color:#333;
            filter:progid:DXImageTransform.Microsoft.Shadow(color=#909090,direction=120,strength=4);/*ie*/
            -moz-box-shadow: 2px 2px 10px #909090;/*firefox*/
            -webkit-box-shadow: 2px 2px 10px #909090;/*safari或chrome*/
            box-shadow:2px 2px 10px #909090;/*opera或ie9*/
        }
        .head-btn {
            float: right;
        }
        .head-btn a {
            text-decoration : none;
            margin: 0 0 0 10px;
        }

        #page-wrapper {
            position: inherit;
            margin: 0;
            padding: 0 30px;
            border-left: 1px solid #e7e7e7;
        }
        .drag-sort{
            cursor: move;
        }

    </style>
@endsection


@section('content')

    <div id="wrapper">

        <!-- Navigation -->
        <div class="nav-box">
            @include('web.public.nav')
        </div>
        <!-- Page Content -->
        <div id="page-wrapper" style="min-height: 635px;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">我创建的项目</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="sortable">
                {{--{{foreach $create_projects as $create_project}}--}}
                    {{--{{$project_id = $create_project.id}}--}}
                    {{--{{$user_id = $create_project.user_id}}--}}
                    {{--<div class="col-lg-3 view-project js_viewProject pannel-project" data-url="{{url("project/{{id_encode($create_project.id)}}")}}">--}}
                        {{--<div class="panel panel-default">--}}
                            {{--<div class="panel-heading">--}}
                            {{--<span class="head-title">--}}
                                {{--<a href="javascript:void(0);" class="drag-sort fa hidden-xs fa-navicon js_dragProjectBtn" title='拖拽排序' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{$create_project.title|truncate:12}}--}}
                            {{--</span>--}}
                            {{--<span class="head-btn">--}}
                                {{--{{if \app\member::has_rule({{$create_project.id}}, 'project', 'update')}}--}}
                                    {{--<a class="fa hidden-xs fa-pencil js_addProjectBtn" data-title='编辑项目' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{/if}}--}}

                                {{--{{if \app\member::has_rule({{$create_project.id}}, 'project', 'delete')}}--}}
                                    {{--<a class="fa hidden-xs fa-trash-o js_deleteProjectBtn" data-title='删除项目' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{/if}}--}}

                                {{--{{if \app\member::has_rule({{$create_project.id}}, 'project', 'transfer')}}--}}
                                    {{--<a class="fa hidden-xs fa-exchange js_transferProjectBtn" data-title='转让项目' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{/if}}--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div class="panel-body">--}}
                                {{--<p>{{$create_project.intro}}</p>--}}
                            {{--</div>--}}
                            {{--<div class="panel-footer">--}}
                                {{--项目创建时间({{$create_project.add_time}})--}}
                                {{--<br>--}}
                                {{--最近更新时间({{$create_project.update_time}})--}}
                            {{--</div>--}}
                        {{--</div>--}}
                     {{--</div>--}}
                {{--{{/foreach}}--}}

                    <!-- /.col-lg-4 -->

            <!-- /.col-lg-4 -->
            <div class="col-lg-3 hidden-xs js_addProjectBtn">
                <div class="panel panel-default">

                    <div class="panel-body project-add">
                        <p class="fa fa-plus">添加项目</p>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">我加入的项目</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            {{--{{foreach $join_projects as $join_project}}--}}
                {{--{{$project_id = $join_project.project_id}}--}}
                {{--{{if _uri('project', $project_id)}}--}}
                    {{--{{$user_id = $join_project.user_id}}--}}
                    {{--{{$join_project_title = _uri('project', $project_id, 'title')}}--}}
                    {{--<div class="col-lg-3 view-project js_viewProject pannel-project" data-url="{{url("project/{{id_encode($join_project.project_id)}}")}}">--}}
                        {{--<div class="panel panel-default">--}}
                            {{--<div class="panel-heading">--}}
                                {{--{{$join_project_title|truncate:14}}--}}
                                {{--<span class="head-btn">--}}
                                {{--{{if \app\member::has_rule($project_id, 'project', 'update')}}--}}
                                    {{--<a class="fa hidden-xs fa-pencil js_addProjectBtn" data-title='编辑项目' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{/if}}--}}

                                {{--{{if \app\member::has_rule($project_id, 'project', 'delete')}}--}}
                                    {{--<a class="fa hidden-xs fa-trash-o js_deleteProjectBtn" data-title='删除项目' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{/if}}--}}

                                {{--{{if \app\member::has_rule($project_id, 'project', 'transfer')}}--}}
                                    {{--<a class="fa hidden-xs fa-exchange js_transferProjectBtn" data-title='转让项目' data-id="{{$create_project.id}}"></a>--}}
                                {{--{{/if}}--}}
                                {{--<a class="fa hidden-xs fa-sign-out js_quitProject" data-toggle="tooltip" title="退出项目" data-id="{{$project_id}}"></a>--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div class="panel-body">--}}
                                {{--<p>{{_uri('project', $project_id, 'intro')}}</p>--}}
                            {{--</div>--}}
                            {{--<div class="panel-footer">--}}
                                {{--创建时间({{_uri('project', $project_id, 'add_time')}})--}}
                                {{--<br>--}}
                                {{--加入时间({{$join_project.add_time}})--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--{{/if}}--}}
            {{--{{/foreach}}--}}


        <div class="col-lg-3">
            <div class="panel panel-default">

                <div class="panel-body project-search js_searchProjectBtn">
                    <p class="fa fa-search">搜索项目</p>
                </div>

            </div>
        </div>
        <!-- /.col-lg-4 -->


        <!-- /#page-wrapper -->

    </div>

    <hr>
    <p class="text-center"></p>

    <!-- /#wrapper -->
    <!-- 添加/编辑项目模态框 -->
    <div class="modal fade" id="js_addProjectModal" tabindex="-9" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加项目</h4>
                </div>
                <div class="modal-body">

                    <div id="js_addProjectIframe" style="min-height: 380px;">
                        @include('web.project.add')
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary js_submit">提交</button>
                </div>

            </div>

        </div>

    </div>
    <!-- 删除项目模态框 -->
    <div class="modal fade" id="js_deleteProjectModal" tabindex="2" role="dialog">
        <div class="modal-dialog" role="document">
            <form role="form" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">确定删除此项目吗？</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-dismissable alert-warning">
                            <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                            项目删除后，该项目下所有版本将被立刻删除，不可恢复，请谨慎操作！
                        </div>
                        <div class="form-group">
                            <input name="id" type="hidden" class="form-control">
                            <input name="password" type="text" class="form-control" placeholder="重要操作，请输入登录密码">
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

    <!-- 转让项目模态框 -->
    <div class="modal fade" id="js_transferProjectModal" tabindex="-9" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">转让项目</h4>
                </div>
                <div class="modal-body">

                    <iframe id="js_transferProjectIframe" src=""></iframe>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary js_submit">提交</button>
                </div>

            </div>

        </div>

    </div>

    </div>
    <!-- /#page-wrapper -->

    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('static/plugins/sortable/sortable.min.js') }}"></script>

    <script>
        $(function(){

            // 拖拽排序
            var el = document.getElementById('sortable');
            var sortable = Sortable.create(el,{
                animation: 150,
                forceFallback: true,
                handle: ".js_dragProjectBtn",
                draggable: ".js_viewProject",
                scrollSensitivity: 100,
                scrollSpeed: 20
            });

            // 添加/编辑项目
            $(".js_addProjectBtn").iframeModal({
                modalItem: '#js_addProjectModal', //modal元素
                iframeItem: '#js_addProjectIframe', //iframe元素
                submitBtn: '.js_submit',
            });

            // 转让项目
            $(".js_transferProjectBtn").iframeModal({
                modalItem: '#js_transferProjectModal', //modal元素
                iframeItem: '#js_transferProjectIframe', //iframe元素
                submitBtn: '.js_submit',
            });

            //搜索项目
            $(".js_searchProjectBtn").click(function(){

                window.location.href = "{{url('project/search')}}";

            });

            //查看项目
            $(".js_viewProject").click(function (event) {

                event.stopPropagation();
                window.location.href = $(this).data('url');

            });

        });
    </script>
@endsection


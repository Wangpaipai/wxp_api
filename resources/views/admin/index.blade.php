@extends('admin.public.app')
@section('title','管理主页')
@section('css')
    <style>
        .huge {
            font-size: 35px;
        }

        .last-item {
            margin: 0;
        }
        .pro_name a{color: #4183c4;}
        .ui.segment.osc_git_box {height: 260px;padding: 0px !important;border: 1px solid #E3E9ED;}
        .osc_git_title{background-color: #fff;}
        .osc_git_box{background-color: #fff;}
        .osc_git_box{border-color: #E3E9ED;}
        .osc_git_info{color: #666;}
        .osc_git_main a{color: #9B9B9B;}
        .osc_git_footer {display: none;}

    </style>
@endsection

@section('content')
    <div id="wrapper">

        <!-- Navigation -->
        @include('admin.public.nav')
        @include('admin.public.sidebar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">管理中心</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row text-center">
                                <div class="col-xs-4">
                                    <i class="fa fa-user fa-4x"></i>
                                    <div>会员</div>
                                </div>
                                <div class="col-xs-8">
                                    <div class="huge">{{ $total['user']['total'] }}</div>
                                    <div>今日新增{{ $total['user']['today'] }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row text-center">
                                <div class="col-xs-4">
                                    <i class="fa fa-th fa-4x"></i>
                                    <div>项目</div>
                                </div>
                                <div class="col-xs-8">
                                    <div class="huge">{{ $total['project']['total'] }}</div>
                                    <div>今日新增{{ $total['project']['today'] }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row text-center">
                                <div class="col-xs-4">
                                    <i class="fa fa-folder-open fa-4x"></i>
                                    <div>模块</div>
                                </div>
                                <div class="col-xs-8">
                                    <div class="huge">{{ $total['project_model']['total'] }}</div>
                                    <div>今日新增{{ $total['project_model']['today'] }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row text-center">
                                <div class="col-xs-4">
                                    <i class="fa fa-files-o fa-4x"></i>
                                    <div>接口</div>
                                </div>
                                <div class="col-xs-8">
                                    <div class="huge">{{ $total['project_api']['total'] }}</div>
                                    <div>今日新增{{ $total['project_api']['today'] }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{--<div class="row">--}}
                {{--<div class="col-lg-12">--}}

                    {{--<!-- /.panel -->--}}
                    {{--<div class="panel panel-default">--}}
                        {{--<div class="panel-heading">--}}
                            {{--<i class="fa fa-dribbble fa-fw"></i> 系统信息--}}
                        {{--</div>--}}
                        {{--<!-- /.panel-heading -->--}}
                        {{--<div class="panel-body">--}}
                            {{--<p>系统环境：</p>--}}
                            {{--<p>使用技术：Laravel+MySQL+Bootstrap+Vue</p>--}}
                            {{--<p>系统开发：<a target="_blank" href="http://www.lxj520.xyz">王小牌</a></p>--}}
                            {{--<p>官方网站：<a target="_blank" href="http://www.lxj520.xyz/">www.lxj520.xyz</a></p>--}}
                        {{--</div>--}}
                        {{--<!-- /.panel-body -->--}}
                    {{--</div>--}}
                    {{--<!-- /.panel -->--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection

@section('js')
@endsection
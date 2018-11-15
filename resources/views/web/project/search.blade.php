@extends('web.public.app')
@section('title', '搜索项目')

@section('css')
    <style>
        ul, li {
            margin: 0px;
            padding: 0px;
        }

        .page-bar {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .page-button-disabled {
            color:#ddd !important;
        }

        .page-bar li {
            list-style: none;
            display: inline-block;
        }

        .page-bar li:first-child > a {
            margin-left: 0px;
        }

        .page-bar a {
            border: 1px solid #ddd;
            text-decoration: none;
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            cursor: pointer;
        }

        .page-bar a:hover {
            background-color: #eee;
        }

        .page-bar .active a {
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .page-bar i {
            font-style: normal;
            color: #d44950;
            margin: 0px 4px;
            font-size: 12px;
        }
    </style>
@endsection


@section('content')
    <div id="wrapper">

        <!-- Navigation -->
        @include('web.public.nav')
        @include('web.public.user_sidebar')
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">搜索项目</h1>
                    <div class="search">
                        <div class="well">

                            <form class="form-inline" method="get">
                                <div class="form-group">
                                    <label>项目名</label>
                                    <input type="text" v-model="param.name" class="form-control" placeholder="支持模糊查询" value="">
                                </div>

                                <div class="form-group">
                                    <label>创建人</label>
                                    <input type="text" v-model="param.username" class="form-control" placeholder="支持模糊查询" value="">
                                </div>

                                <button type="submit" class="btn btn-primary">搜索</button>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>项目名称</th>
                                        <th>项目简介</th>
                                        <th>创建人/账号</th>
                                        <th>成员数</th>
                                        <th>创建时间</th>

                                        <th>操作面板</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td ></td>
                                        <td ></td>
                                        <td ><br></td>
                                        <td ></td>
                                        <td ></td>
                                        <td >
                                            <a class="btn btn-info btn-xs disabled">创建者</a>
                                            <a class="btn btn-warning btn-xs disabled">参与者</a>
                                            <a class="btn btn-default btn-xs disabled">审核中</a>
                                            <a class="btn btn-success btn-xs js_addProjectBtn">加入项目</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                                <div class="col-sm-12" style="text-align: center">
                                    <div id="app">
                                        <vue-pagination :cur.sync="cur" :all.sync="all" @btn-click="listen"></vue-pagination>
                                    </div>
                                </div>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

                @include('web.public.record')
                <!-- /.col-lg-6 -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <hr>
@endsection

@section('js')
    <script src="{{ asset('static/js/pagination.js') }}"></script>
    <script>
        var app = new Vue({
            el:'#wrapper',
            data:{
                cur: 1,
                all: 100,
                param:{
                    name:'',
                    username:''
                }
            },
            created:function(){
                
            },
            components: {
                // 引用组件
                'vue-pagination': Vue.Pagination
            },
            methods:{
                listen: function (data) {
                }
            }
        })
    </script>
@endsection

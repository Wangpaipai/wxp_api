@extends('web.public.app')
@section('title', '申请管理')

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
    <div id="wrapper">

        <!-- Navigation -->
        @include('web.public.nav')
        @include('web.public.user_sidebar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">申请管理</h1>
                    <div class="search">
                        <div class="well">
                            <form class="form-inline" role="search">
                                <div class="form-group">
                                    <label>项目名</label>
                                    <input type="text" v-model="param.name" class="form-control" id="exampleInputName3" placeholder="支持模糊查询">
                                </div>

                                <div class="form-group">
                                    <label>申请人</label>
                                    <input type="text" v-model="param.username" class="form-control" id="exampleInputName2" placeholder="支持模糊查询">
                                </div>

                                <button type="button" @click="applySearch" class="btn btn-primary">搜索</button>
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
                                        <th>申请人/账号</th>
                                        <th>申请加入项目</th>
                                        <th>申请加入时间</th>

                                        <th>操作面板</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td ></td>
                                        <td ></td>

                                        <td ></td>
                                        <td >
                                            <a class="btn btn-success btn-xs js_passApplyBtn">通过</a>
                                            <a class="btn btn-warning btn-xs disabled">已通过</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <p v-show="isLoadingShow" style="text-align: center">@{{ altMsg }}</p>
                            <div class="col-sm-12" style="text-align: center">
                                <div id="app" v-if="all > 15">
                                    <vue-pagination :cur.sync="cur" :all.sync="all" @btn-click="listen"></vue-pagination>
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

    </div>
@endsection

@section('js')
    <script src="{{ asset('static/js/pagination.js') }}"></script>
    <script>
        function requestApply(that,param) {
            that.isLoadingShow = true;
            that.altMsg = '加载中......';
            axios.get(that.applyUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.all = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    for(let item in data.data.apply){
                        data.data.apply[item].created_at = timestampToTime(data.data.apply[item].created_at);
                    }
                    that.apply = data.data.apply;
                }else{
                    that.altMsg = '暂无数据......';
//                            layer.msg(data.msg,{icon:2,time:2000});
                }
            })
            .catch(function (error) {
                console.log('error');
            });
        }
        var app = new Vue({
            el:'#wrapper',
            data:{
                cur: 0,//当前页
                all: 0,//总数
                isLoadingShow:false,
                altMsg:'加载中......',
                applyUrl:'{{ route('web.project.apply.getlist') }}',
                apply:[],
                param:{
                    name:'',
                    username:''
                }
            },
            create:function(){

            },
            components: {
                // 引用组件
                'vue-pagination': Vue.Pagination
            },
            methods:{
                listen: function (data) {

                },
                applySearch:function(event){}
            }
        })
    </script>
@endsection


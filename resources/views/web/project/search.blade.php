@extends('web.public.app')
@section('title', '搜索项目')

@section('css')
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

                                <button type="button" @click="search" class="btn btn-primary">搜索</button>
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
                                        <th>创建人</th>
                                        <th>创建时间</th>

                                        <th>操作面板</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(item,index) in project">
                                        <td >@{{ item.name }}</td>
                                        <td >@{{ item.brief }}</td>
                                        <td >@{{ item.username }}</td>
                                        <td >@{{ item.created_at }}</td>
                                        <td >
                                            <a class="btn btn-info btn-xs disabled" v-if="item.status == 1">创建者</a>
                                            <a class="btn btn-warning btn-xs disabled" v-if="item.status == 3">参与者</a>
                                            <a class="btn btn-default btn-xs disabled" v-if="item.status == 2">审核中</a>
                                            <a class="btn btn-success btn-xs js_addProjectBtn" v-if="item.status == 4" @click="apply(item.id,index)">加入项目</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <p v-show="isLoadingShow" style="text-align: center">@{{ altMsg }}</p>
                                <div class="col-sm-12" style="text-align: center">
                                    <div id="app" v-if="total > 15">
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

    </div>
@endsection

@section('js')
    <script src="{{ asset('static/js/pagination.js') }}"></script>
    <script>
        function search(param,that){
            that.isLoadingShow = true;
            that.altMsg = '加载中......';
            axios.get(that.requestUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.total = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    that.all = param.page_count;
                    for(let item in data.data.project){
                        data.data.project[item].created_at = timestampToTime(data.data.project[item].created_at);
                    }
                    that.project = data.data.project;
                }else{
                    that.project = [];
                    that.altMsg = '暂无数据';
//                            layer.msg(data.msg,{icon:2,time:2000});
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        var app = new Vue({
            el:'#wrapper',
            data:{
                cur: 0,//当前页
                all: 0,//总数
                total:0,
                param:{
                    name:'',
                    username:''
                },
                project:[],
                isLoadingShow:false,
                requestUrl:'{{ route('web.project.search.request') }}',
                altMsg:'加载中......',
                applyData:'{{ route('web.project.apply') }}'
            },
            created:function(){
                var that = this;
                search(that.param,that);
            },
            components: {
                // 引用组件
                'vue-pagination': Vue.Pagination
            },
            methods:{
                listen: function (data) {
                    var that = this;
                    var param = {
                        name:that.param.name,
                        username:that.param.username,
                        page:data
                    };
                    search(param,that);
                },
                search:function(event){
                    var that = this;
                    search(that.param,that);
                },
                apply:function(data,index){
                    var that = this;
                    layer.open({
                        content: '请确认是否申请加入此项目?',
                        yes: function(layIndex, layero){
                            layer.close(layIndex);
                            axios.get(that.applyData,{
                                params:{
                                    project_id:data
                                }
                            })
                            .then(function (response) {
                                var data = response.data;
                                if(data.status){
                                    that.project[index].status = 2;
                                    layer.msg(data.msg,{icon:1,time:2000});
                                }else{
                                    layer.msg(data.msg,{icon:2,time:2000});
                                }
                            })
                            .catch(function (error) {
                                console.log('error');
                            });
                        }
                    });
                }
            }
        })
    </script>
@endsection

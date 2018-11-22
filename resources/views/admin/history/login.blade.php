@extends('admin.public.app')
@section('title','登录历史')

@section('css')
@endsection

@section('content')
    <div id="wrapper">
        @include('admin.public.nav')
        @include('admin.public.sidebar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">登录历史</h1>
                    <div class="search">
                        <div class="well">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label>昵称/账号</label>
                                    <input type="text" v-model="param.name" class="form-control" placeholder="支持模糊查询">
                                </div>
                                <button type="button" @click="searchHistory" class="btn btn-primary">搜索</button>
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
                                        <th>用户名</th>
                                        <th>邮箱</th>
                                        <th>登录IP</th>
                                        <th>登录时间</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in history">
                                        <td >@{{ item.name }}</td>
                                        <td >@{{ item.email }}</td>
                                        <td >@{{ item.ip }}</td>
                                        <td >@{{ item.created_at }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="col-sm-12">
                                    <p v-show="isLoadingShow" style="text-align: center">@{{ altMsg }}</p>
                                    <div class="col-sm-12" style="text-align: center">
                                        <div id="app" v-if="total > 10">
                                            <vue-pagination :cur.sync="cur" :all.sync="all" @btn-click="listen"></vue-pagination>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
@endsection
@section('js')
    <script src="{{ asset('static/js/pagination.js') }}"></script>
    <script>
        function getHistoryList(param,that){
            that.isLoadingShow = true;
            that.altMsg = '加载中......';
            axios.get(that.historyUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.total = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    that.all = data.data.page_count;
                    for(let item in data.data.history){
                        data.data.history[item].created_at = timestampToTime(data.data.history[item].created_at);
                    }
                    that.history = data.data.history;
                }else{
                    that.history = [];
                    that.altMsg = '暂无数据';
//                            layer.msg(data.msg,{icon:2,time:2000});
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }
        var app = new Vue({
            el: '#wrapper',
            data: {
                cur: 1,//当前页
                all: 100,//总页数
                total: 0,//总条数
                isLoadingShow: false,
                altMsg: '',
                windowHeight: 0,
                historyUrl:'{{ route('admin.history.list') }}',
                history:[],
                param:{
                    name:''
                }
            },
            created: function () {
                var that = this;
                that.windowHeight = window.innerHeight;
                getHistoryList(that.param,that);
            },
            components: {
                // 引用组件
                'vue-pagination': Vue.Pagination
            },
            methods: {
                listen: function (data) {
                    var that = this;
                    var param = that.param;
                    param.page = data;
                    getHistoryList(param,that);
                },
                searchHistory:function(){
                    var that = this;
                    getHistoryList(that.param,that);
                }
            }
        })
    </script>
@endsection
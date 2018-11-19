@extends('web.public.app')
@section('title', '登录历史')

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

                    <h1 class="page-header">登录历史</h1>
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
                                        <th>登录IP</th>
                                        <th>登录时间</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in history">
                                        <td >@{{ item.ip }}</td>
                                        <td >@{{ item.created_at }}</td>
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
            axios.get(that.historyUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.all = data.data.page_count;
                    that.total = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    for(let item in data.data.history){
                        data.data.history[item].created_at = timestampToTime(data.data.history[item].created_at);
                    }
                    that.history = data.data.history;
                }else{
                    that.project = [];
                    that.altMsg = '暂无数据';
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
                total:0,
                isLoadingShow:false,
                altMsg:'加载中......',
                historyUrl:'{{ route('web.login.history') }}',
                history:[]
            },
            created:function(){
                var that = this;
                search({page:1},that);
            },
            components: {
                // 引用组件
                'vue-pagination': Vue.Pagination
            },
            methods:{
                listen: function (data) {
                    var that = this;
                    search({page:data},that);
                }
            }
        })
    </script>
@endsection

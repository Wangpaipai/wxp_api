@extends('web.public.app')
@section('title', '申请管理')

@section('css')
    <style>
        .del{
            background: #d9534f !important;
        }
        .refuse{
            background: #d9534f !important;
            border: 1px solid #d9534f !important;
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
                                        <th>申请人</th>
                                        <th>申请加入项目</th>
                                        <th>申请加入时间</th>

                                        <th>操作面板</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item,index) in apply">
                                        <td >@{{ item.username }}</td>
                                        <td >@{{ item.name }}</td>
                                        <td >@{{ item.created_at }}</td>
                                        <td >
                                            <a v-if="item.apply == 1" @click="applyUpdate(item.id,2,index)" class="btn btn-success btn-xs js_passApplyBtn">通过</a>
                                            <a v-if="item.apply == 1" @click="applyUpdate(item.id,0,index)" class="btn btn-success btn-xs refuse">拒绝</a>
                                            <a v-if="item.apply == 2" class="btn btn-warning btn-xs disabled">已通过</a>
                                            <a v-if="item.apply == 0" class="btn btn-warning btn-xs disabled del">已拒绝</a>
                                            <a v-if="item.apply == 3" class="btn btn-default btn-xs disabled">已退出</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <p v-show="isLoadingShow" style="text-align: center">@{{ altMsg }}</p>
                            <div class="col-sm-12" style="text-align: center">
                                <div id="app" v-if="total > 15">
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
        function requestApply(param,that) {
            that.isLoadingShow = true;
            that.altMsg = '加载中......';
            axios.get(that.applyUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.all = data.data.page_count;
                    that.total = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    for(let item in data.data.apply){
                        data.data.apply[item].created_at = timestampToTime(data.data.apply[item].created_at);
                    }
                    that.apply = data.data.apply;
                }else{
                    that.apply = [];
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
                isLoadingShow:false,
                altMsg:'加载中......',
                applyUrl:'{{ route('web.project.apply.getlist') }}',
                apply:[],
                param:{
                    name:'',
                    username:''
                },
                applyUpdateUrl:'{{ route('web.project.apply.update') }}'
            },
            created:function(){
                var that = this;
                requestApply(that.param,that);
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
                    }
                    requestApply(param,that);
                },
                applySearch:function(event){
                    var that = this;
                    requestApply(that.param,that);
                },
                applyUpdate:function(group_id,apply,index){
                    var that = this;
                    axios.get(that.applyUpdateUrl,{
                            params:{
                                group_id:group_id,
                                apply:apply
                            }
                        })
                    .then(function (response) {
                        var data = response.data;
                        if(data.status){
                            layer.msg(data.msg,{icon:1,time:2000});
                            that.apply[index].apply = apply;
                        }else{
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            }
        })
    </script>
@endsection


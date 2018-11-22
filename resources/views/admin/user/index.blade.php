@extends('admin.public.app')
@section('title','会员列表')

@section('css')
@endsection

@section('content')
    <div id="wrapper">

        <!-- Navigation -->
        @include('admin.public.nav')
        @include('admin.public.sidebar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">用户管理</h1>

                    <div class="search">
                        <div class="well">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label>昵称/账号</label>
                                    <input type="text" v-model="param.name" class="form-control" placeholder="支持模糊查询">
                                </div>
                                <button type="button" @click="searchMember" class="btn btn-primary">搜索</button>
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
                                        <th>创建项目</th>
                                        <th>参与项目</th>
                                        <th>注册时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in member">
                                        <td >@{{ item.name }}</td>
                                        <td >@{{ item.email }}</td>
                                        <td >@{{ item.my_project }}</td>
                                        <td >@{{ item.project_count }}</td>
                                        <td >@{{ item.created_at }}</td>
                                        {{--<td >--}}
                                            {{--{{if $user.status}}--}}
                                            {{--<i class="fa fa-check"></i>--}}
                                            {{--{{else}}--}}
                                            {{--<i class="fa fa-times"></i>--}}
                                            {{--{{/if}}--}}
                                        {{--</td>--}}
                                        {{--<td ></td>--}}
                                        {{--<td>--}}
                                            {{--<a type="button" class="btn btn-danger btn-xs js_changeStatusBtn">冻结用户</a>--}}
                                            {{--<a type="button" class="btn btn-success btn-xs js_changeStatusBtn">激活用户</a>--}}
                                            {{--<a type="button" class="btn btn-warning btn-xs js_resetPasswordBtn">重置密码</a>--}}
                                        {{--</td>--}}
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
        function getProjectList(param,that){
            that.isLoadingShow = true;
            that.altMsg = '加载中......';
            axios.get(that.memberUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.total = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    that.all = data.data.page_count;
                    for(let item in data.data.member){
                        data.data.member[item].created_at = timestampToTime(data.data.member[item].created_at);
                    }
                    that.member = data.data.member;
                }else{
                    that.member = [];
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
                memberUrl:'{{ route('admin.member.list') }}',
                member:[],
                param:{
                    name:''
                }
            },
            created: function () {
                var that = this;
                that.windowHeight = window.innerHeight;
                getProjectList(that.param,that);
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
                    getProjectList(param,that);
                },
                searchMember:function(){
                    var that = this;
                    getProjectList(that.param,that);
                }
            }
        })
    </script>
@endsection

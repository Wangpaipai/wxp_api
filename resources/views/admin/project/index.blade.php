@extends('admin.public.app')
@section('title','项目列表')

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
                    <h1 class="page-header">项目管理</h1>
                    <div class="search">
                        <div class="well">
                            <form class="form-inline">
                                <div class="form-group">
                                    <label>项目名</label>
                                    <input v-model="param.name" type="text" class="form-control" placeholder="支持模糊查询" value="">
                                </div>

                                <div class="form-group">
                                    <label>创建人</label>
                                    <input v-model="param.username" type="text" class="form-control" placeholder="支持模糊查询" value="">
                                </div>

                                <button type="button" @click="searchProject" class="btn btn-primary">搜索</button>
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
                                        <th>创建人</th>
                                        <th>成员数</th>
                                        <th>模块数</th>
                                        <th>接口数</th>
                                        <th>创建时间</th>
                                        <th>操作面板</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in project">
                                        <td>@{{ item.name }}</td>
                                        <td>@{{ item.username }}</td>
                                        <td>@{{ item.member_count }}</td>
                                        <td>@{{ item.model_count }}</td>
                                        <td>@{{ item.api_count }}</td>
                                        <td>@{{ item.created_at }}</td>
                                        <td>
                                            {{--<button type="button" class="btn btn-warning btn-xs js_transferProjectBtn" data-id="{{$project_id}}">转让</button>--}}
                                            {{--<button type="button" class="btn btn-danger btn-xs js_deleteProjectBtn" data-id="{{$project_id}}">删除</button>--}}
                                            <a class="btn btn-success btn-xs js_viewProjectBtn" target="_blank" :href="'/project/api/index/' + item.id">查看</a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                                <div class="col-sm-12">
                                    <p v-show="isLoadingShow" style="text-align: center">@{{ altMsg }}</p>
                                    <div class="col-sm-12" style="text-align: center">
                                        <div id="app" v-if="total > 15">
                                            <vue-pagination :cur.sync="cur" :all.sync="all" @btn-click="listen"></vue-pagination>
                                        </div>
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

            <!-- 删除项目模态框 -->
            <div class="modal fade" id="js_deleteProjectModal" tabindex="2" role="dialog">
                <div class="modal-dialog" role="document">
                    <form role="form">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">确定删除此项目吗？</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-dismissable alert-warning">
                                    <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                                    项目删除后，该项目下所有数据将被立刻删除，不可恢复，请谨慎操作！
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

                            <iframe id="js_transferProjectIframe" style="min-height: 320px;" src=""></iframe>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary js_submit">提交</button>
                        </div>

                    </div>

                </div>

            </div>

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
            axios.get(that.projectUrl,{
                params:param
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.isLoadingShow = false;
                    that.total = data.data.total;
                    that.cur = param.page ? param.page : 1;
                    that.all = data.data.page_count;
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
            el: '#wrapper',
            data: {
                cur: 1,//当前页
                all: 100,//总页数
                total: 0,//总条数
                isLoadingShow: false,
                altMsg: '',
                windowHeight: 0,
                projectUrl:'{{ route('admin.project.list') }}',
                project:[],
                param:{
                    name:'',
                    username:''
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
                searchProject:function(){
                    var that = this;
                    getProjectList(that.param,that);
                }
            }
        })
    </script>
@endsection
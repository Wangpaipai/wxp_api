@extends('web.public.app')
@section('title', '项目主页')

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

    @include('web.public.nav')
    @include('web.public.project_sidebar')
    <div id="wrapper">

        <!-- Navigation -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1>项目成员 </h1>
                        <div class="opt-btn">
                            @if($group['is_update'])
                                <a @click="addRole" href="javascript:void(0);" class="btn hidden-xs btn-sm btn-success" data-id="{{ $project->id }}" data-title='添加成员'><i class="fa fa-fw fa-plus"></i>添加</a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">

                        @include('web.project.tab')

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>昵称/邮箱</th>
                                        <th>查看权限</th>
                                        <th>编辑权限</th>
                                        <th>删除权限</th>
                                        <th>项目转让权限</th>
                                        <th>加入时间</th>
                                        <th width="15%">操作面板</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(item,index) in member">
                                        <td>@{{ item.name }}</td>
                                        <td>@{{ item.is_show ? 'Y' : 'N' }}</td>
                                        <td>@{{ item.is_update ? 'Y' : 'N' }}</td>
                                        <td>@{{ item.is_del ? 'Y' : 'N' }}</td>
                                        <td>@{{ item.is_give ? 'Y' : 'N' }}</td>
                                        <td>@{{ item.created_at }}</td>
                                        <td width="15%">
                                            @if($group['is_update'])
                                                <a type="button" @click="role(index)" class="btn btn-success btn-xs js_addMemberBtn" data-title="编辑权限"><i class="fa fa-fw fa-key"></i>权限</a>
                                            @endif
                                            @if($group['is_del'])
                                                <a type="button" @click="roleRemove(item.id)" class="btn btn-danger btn-xs js_quitProjectBtn" data-id=""><i class="fa fa-fw fa-sign-out"></i>移除</a>
                                            @endif
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
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                @include('web.public.record')
                <!-- /.col-lg-12 -->
            </div>

        </div>
        <!-- /#page-wrapper -->


        <!-- /#wrapper -->
        <div class="modal fade" id="js_addMemberModal" role="dialog" v-show="createShow" :class="{in:createShow}" style="display: block">
            <div class="modal-backdrop fade in" v-show="createShow" :style="{height:windowHeight + 'px'}"></div>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="createShow = !createShow" aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">添加成员</h4>
                    </div>
                    <div class="modal-body">
                        <div id="js_addProjectIframe" style="min-height: 380px;">
                            @include('web.member.add')
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="createShow = !createShow" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" @click="roleCreate">提交</button>
                    </div>

                </div>

            </div><!-- /.modal-dialog -->
        </div>




    </div>
@endsection

@section('js')
    <script src="{{ asset('static/js/pagination.js') }}"></script>
    <script>
        function getMemberList(param,that){
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
            el:'#wrapper',
            data:{
                cur: 1,//当前页
                all: 100,//总页数
                total:0,//总条数
                isLoadingShow:false,
                altMsg:'',
                memberUrl:'{{ route('web.project.api.groupList') }}',
                member:[],
                project:'{{ $project->id }}',
                createShow:false,
                windowHeight:0,
                is_create:false,
                roleData:{
                    role_group:['show']
                },
                memberType:'add',
                createGroup:'{{ route('web.project.api.group.create') }}',
                updateGroup:'{{ route('web.project.api.group.update') }}',
                removeGroup:'{{ route('web.project.api.group.remove') }}'
            },
            created:function(){
                var that = this;
                that.windowHeight = window.innerHeight;
                getMemberList({project:that.project},that);
            },
            components: {
                // 引用组件
                'vue-pagination': Vue.Pagination
            },
            methods:{
                listen: function (data) {
                    var that = this;
                    getMemberList({project:that.project,page:data},that);
                },
                roleRemove:function(group){
                    if(!group){
                        return layer.msg('记录不存在',{icon:2,time:2000});
                    }
                    var that = this;
                    layer.open({
                        content: '请确认是否将此用户移除?',
                        yes: function(layIndex, layero){
                            layer.close(layIndex);
                            axios.get(that.removeGroup,{
                                params:{
                                    group:group,
                                    project:that.project
                                }
                            })
                            .then(function (response) {
                                var data = response.data;
                                if(data.status){
                                    layer.msg(data.msg,{icon:1,time:2000});
                                    that.listen(1);
                                }else{
                                    layer.msg(data.msg,{icon:2,time:2000});
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        }
                    });
                },
                roleCreate:function(event){
                    var that = this;
                    if(!that.roleData.name){
                        return layer.msg('用户名/邮箱不能为空',{icon:2,time:2000});
                    }
                    if(that.memberType === 'add'){
                        var url = that.createGroup;
                    }else{
                        var url = that.updateGroup;
                    }
                    that.roleData.project = that.project;
                    axios.get(url,{
                        params:that.roleData
                    })
                    .then(function (response) {
                        var data = response.data;
                        if(data.status){
                            that.createShow = false;
                            layer.msg(data.msg,{icon:1,time:2000});
                            that.listen(1);
                        }else{
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                addRole:function(){
                    this.roleData = {
                        role_group:['show']
                    };
                    this.createShow = true;
                    this.is_create = true;
                    this.memberType = 'add';
                },
                role:function(index){
                    var role = [];
                    var member = this.member[index];
                    if(member.is_show){
                        role.push('show');
                    }
                    if(member.is_del){
                        role.push('delete');
                    }
                    if(member.is_give){
                        role.push('give');
                    }
                    if(member.is_update){
                        role.push('update');
                    }
                    this.roleData = {
                        role_group:role,
                        name:member.name,
                        id:member.id
                    };
                    this.createShow = true;
                    this.is_create = false;
                    this.memberType = 'update';
                }

            }
        })
    </script>
    <script>
        $(function(){

            // 添加/编辑成员
            $(".js_addMemberBtn").iframeModal({
                modalItem: '#js_addMemberModal', //modal元素
                iframeItem: '#js_addMemberIframe', //iframe元素
                submitBtn: '.js_submit',
            });

            //移除成功
            $(".js_quitProjectBtn").click(function(event){
                // 阻止事件冒泡
                event.stopPropagation();

                var thisObj = $(this);

                var memberId    = thisObj.data('id');

                var url = "{{url('member/delete')}}";

                confirm('确认将该成员移出项目?', function(){

                    $.post(url, { member_id:memberId }, function(json){

                        if(json.code == 200){

                            alert(json.msg, 500, function () {
                                thisObj.closest('tr').remove();
                            });

                        }else{

                            alert(json.msg, 2000);

                        }

                    }, 'json');
                });

            });

        });
    </script>
@endsection
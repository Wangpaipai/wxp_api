@extends('web.public.app')
@section('title', '选择项目')

@section('css')
    <style>
        .panel-body {
            height: 80px;
            overflow: hidden;
        }

        .project-add,.project-search {
            height: 180px;
            overflow: hidden;
            text-align:center;
            line-height:140px;
            font-size: 36px;
        }

        .panel:hover  {
            background-color:#EFEFEF;
            cursor: pointer;
            solid;background:#fff;color:#333;
            filter:progid:DXImageTransform.Microsoft.Shadow(color=#909090,direction=120,strength=4);/*ie*/
            -moz-box-shadow: 2px 2px 10px #909090;/*firefox*/
            -webkit-box-shadow: 2px 2px 10px #909090;/*safari或chrome*/
            box-shadow:2px 2px 10px #909090;/*opera或ie9*/
        }
        .head-btn {
            float: right;
        }
        .head-btn a {
            text-decoration : none;
            margin: 0 0 0 10px;
        }

        #page-wrapper {
            position: inherit;
            margin: 0;
            padding: 0 30px;
            border-left: 1px solid #e7e7e7;
        }
        .drag-sort{
            cursor: move;
        }
        .panel-body{
            overflow:hidden;
            text-overflow:ellipsis;
            display:-webkit-box;
            -webkit-box-orient:vertical;
            -webkit-line-clamp:2;
        }
    </style>
@endsection


@section('content')

    <div id="wrapper">

        <!-- Navigation -->
        <div class="nav-box">
            @include('web.public.nav')
        </div>
        <!-- Page Content -->
        <div id="page-wrapper" style="min-height: 635px;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">我创建的项目</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="sortable">
                    <div class="col-lg-3 view-project pannel-project" v-for="(item,index) in project" @click="locationProject(item.id,index,1)">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            <span class="head-title">
                                <a href="javascript:void(0);" class="drag-sort fa hidden-xs fa-navicon js_dragProjectBtn" title='' :data-id="item.id"></a>
                                @{{ item.name }}
                            </span>
                            <span class="head-btn" @click.stop>
                                <a href="javascript:void(0);" data-type="1" class="fa hidden-xs fa-pencil js_addProjectBtn" @click="objectUpdate" data-title='编辑项目' :data-id="item.id"></a>
                                <a href="javascript:void(0);" data-type="1" class="fa hidden-xs fa-trash-o js_deleteProjectBtn" @click="objectRemove" data-title='删除项目' :data-id="item.id" :data-index="index"></a>
                                <a href="javascript:void(0);" data-type="1" class="fa hidden-xs fa-exchange js_transferProjectBtn" @click="objectGive(index,1)" data-title='转让项目' :data-id="item.id"></a>
                            </span>
                            </div>
                            <div class="panel-body">
                                <p>@{{ item.brief }}</p>
                            </div>
                            <div class="panel-footer">
                                项目创建时间(@{{ item.created_at }})
                                <br>
                                最近更新时间(@{{ item.updated_at }})
                            </div>
                        </div>
                     </div>

                    <!-- /.col-lg-4 -->

            <!-- /.col-lg-4 -->
            <div class="col-lg-3 hidden-xs js_addProjectBtn" @click="createShowEvent">
                <div class="panel panel-default">

                    <div class="panel-body project-add">
                        <p class="fa fa-plus">添加项目</p>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">我加入的项目</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 view-project js_viewProject pannel-project" v-for="(item,index) in group" @click="locationProject(item.id,index,2)">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @{{ item.name }}
                        <span class="head-btn" @click.stop>
                            <a data-type="2" v-if="item.is_update" class="fa hidden-xs fa-pencil js_addProjectBtn" @click="objectUpdate" title='编辑项目' :data-id="item.id"></a>
                            <a data-type="2" v-if="item.is_del" class="fa hidden-xs fa-trash-o js_deleteProjectBtn" @click="objectRemove" title='删除项目' :data-id="item.id" :data-index="index"></a>
                            <a data-type="2" v-if="item.is_give" class="fa hidden-xs fa-exchange js_transferProjectBtn" @click="objectGive(index,2)" title='转让项目' :data-id="item.id"></a>
                            <a class="fa hidden-xs fa-sign-out js_quitProject" @click="projectOut(item.id,index)" data-toggle="tooltip" title="退出项目" :data-id="item.id"></a>
                        </span>
                    </div>
                    <div class="panel-body">
                        <p>@{{ item.brief }}</p>
                    </div>
                    <div class="panel-footer">
                        创建时间(@{{ item.created_at }})
                        <br>
                        加入时间(@{{ item.updated_at }})
                    </div>
                </div>
            </div>


        <div class="col-lg-3">
            <div class="panel panel-default">

                <div onclick="location.href='{{ route('web.project.search') }}'" class="panel-body project-search js_searchProjectBtn">
                    <p class="fa fa-search">搜索项目</p>
                </div>

            </div>
        </div>
        <!-- /.col-lg-4 -->


        <!-- /#page-wrapper -->

    </div>


    <p class="text-center">
        @include('web.public.record')
    </p>

    <!-- /#wrapper -->
    <!-- 添加/编辑项目模态框 -->
    <div class="modal fade" id="js_addProjectModal" tabindex="-9" v-show="createShow" :class="{in:createShow}" role="dialog" style="display: block">
        <div class="modal-backdrop fade in" v-show="createShow" :style="{height:windowHeight + 'px'}"></div>
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="createShow = !createShow" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加项目</h4>
                </div>
                <div class="modal-body">

                    <div id="js_addProjectIframe" style="min-height: 380px;">
                        @include('web.project.add')
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="createShow = !createShow" data-dismiss="modal">关闭</button>
                    <button type="button" @click="createProject" class="btn btn-primary js_submit">提交</button>
                </div>

            </div>

        </div>

    </div>
    <!-- 删除项目模态框 -->
    <div class="modal fade" id="js_deleteProjectModal" v-show="removeShow" :class="{in:removeShow}" tabindex="2" role="dialog" style="display: block">
        <div class="modal-backdrop fade in" v-show="removeShow" :style="{height:windowHeight + 'px'}"></div>
        <div class="modal-dialog" role="document">
            <form role="form" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="removeShow = !removeShow" aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">确定删除此项目吗？</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-dismissable alert-warning">
                            <i class="fa fa-fw fa-info-circle"></i>&nbsp;
                            项目删除后，该项目下所有版本将被立刻删除，不可恢复，请谨慎操作！
                        </div>
                        <div class="form-group">
                            <input name="id" type="hidden" v-model="removeProject.id" class="form-control">
                            <input name="password" v-model="removeProject.password" type="password" class="form-control" placeholder="重要操作，请输入登录密码">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="removeShow = !removeShow" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" @click="projectDel" class="btn btn-danger js_submit">删除</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>

    <!-- 转让项目模态框 -->
    <div class="modal fade" id="js_transferProjectModal" v-show="giveShow" :class="{in:giveShow}" tabindex="2" role="dialog" style="display: block">
        <div class="modal-backdrop fade in" v-show="giveShow" :style="{height:windowHeight + 'px'}"></div>
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="giveShow = !giveShow" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">转让项目</h4>
                </div>
                <div class="modal-body">

                    <div id="js_addProjectIframe" style="min-height: 380px;">
                        @include('web.project.transfer')
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" @click="giveShow = !giveShow" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" @click="giveProject" class="btn btn-primary js_submit">提交</button>
                </div>

            </div>

        </div>

    </div>

    </div>
    <!-- /#page-wrapper -->
    </div>

    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('static/plugins/sortable/sortable.min.js') }}"></script>

    <script>
        $(function(){

            function created(that){
                that.windowHeight = window.innerHeight;
                axios.get(that.projectListUrl,'')
                .then(function (response) {
                    var data = response.data;
                    if(data.status){
                        for(let item in data.data.project){
                            data.data.project[item].created_at = timestampToTime(data.data.project[item].created_at);
                            data.data.project[item].updated_at = timestampToTime(data.data.project[item].updated_at);
                        }
                        for(let val in data.data.group){
                            data.data.group[val].created_at = timestampToTime(data.data.group[val].created_at);
                            data.data.group[val].updated_at = timestampToTime(data.data.group[val].updated_at);
                        }
                        that.project = data.data.project;
                        that.group = data.data.group;
                        eventApp();
                    }else{
                        layer.msg(data.msg,{icon:2,time:2000});
                    }
                })
                .catch(function (error) {
                    console.log('error');
                });
            }

            var app = new Vue({
                el:'#wrapper',
                data:{
                    create:{
                        param:[
                            {name:'formal',title:'正式环境',url:''}
                        ],
                        is_show:1
                    },
                    isChecked:true,
                    isRequest:true,
                    createUrl:'{{ route('web.project.create') }}',
                    project:[],
                    group:[],
                    projectListUrl:'{{ route('web.project.list') }}',
                    getProject:'{{ route('web.project.getData') }}',
                    createShow:false,
                    windowHeight:0,
                    removeShow:false,
                    removeProject:{
                        password:'',
                        id:'',
                        index:''
                    },
                    removeUrl:'{{ route('web.project.remove') }}',
                    type:1,
                    projectOutUrl:'{{ route('web.project.apply.out') }}',
                    member:[],
                    giveShow:false,
                    give:{},
                    memberListUrl:'{{ route('web.project.memberList') }}',
                    giveUrl:'{{ route('web.project.give') }}'
                },
                created: function () {
                    var that = this;
                    created(that);
                },
                methods:{
                    giveProject:function(event){
                        var that = this;
                        if(!that.give.password){
                            return layer.msg('请输入密码',{icon:2,time:2000});
                        }
                        if(!that.give.uid){
                            return layer.msg('请选择转让用户',{icon:2,time:2000});
                        }
                        axios.get(that.giveUrl,{
                            params:{
                                project_id:that.give.project_id,
                                uid:that.give.uid,
                                password:that.give.password
                            }
                        })
                        .then(function (response) {
                            var data = response.data;
                            if(data.status){
                                created(that);
                                that.giveShow = false;
                                layer.msg(data.msg,{icon:1,time:2000});
                            }else{
                                layer.msg(data.msg,{icon:2,time:2000});
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    },
                    objectGive:function(index,type){
                        var that = this;
                        if(type == 1){
                            var project = that.project[index];
                        }else{
                            var project = that.group[index];
                        }
                        axios.get(that.memberListUrl,{
                            params:{
                                project_id:project.id
                            }
                        })
                        .then(function (response) {
                            var data = response.data;
                            if(data.status){
                                that.giveShow = true;
                                that.member = data.data;
                                that.give.name = project.name;
                                that.give.project_id = project.id;
                                that.give.uid = 0;
                            }else{
                                layer.msg(data.msg,{icon:2,time:2000});
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    },
                    locationProject:function(data,index,type){
                        if(type == 2){
                            var project = this.group;
                            if(project[index].is_show){
                                location.href = '/project/api/index/' + data;
                            }else{
                                layer.msg('无权限查看此项目',{icon:0,time:2000});
                            }
                        }else{
                            location.href = '/project/api/index/' + data;
                        }
                    },
                    projectOut:function(data,index){
                        var that = this;
                        layer.open({
                            content: '请确认是否退出此项目?',
                            yes: function(layIndex, layero){
                                layer.close(layIndex);
                                axios.get(that.projectOutUrl,{
                                    params:{
                                        project_id:data
                                    }
                                })
                                .then(function (response) {
                                    var data = response.data;
                                    if(data.status){
                                        that.group.splice(index,1);
                                        layer.msg(data.msg,{icon:1,time:2000});
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
                    projectDel:function(event){
                        var that = this;
                        if(!that.removeProject.id){
                            return layer.msg('项目不存在',{icon:2,time:2000});
                        }
                        if(!that.removeProject.password){
                            return layer.msg('请输入密码',{icon:2,time:2000});
                        }
                        axios.get(this.removeUrl,{
                            params:this.removeProject
                        })
                        .then(function (response) {
                            var data = response.data;
                            if(data.status){
                                if(that.type == 1){
                                    that.project.splice(that.removeProject.index,1);
                                }else{
                                    that.project.group(that.removeProject.index,1);
                                }

                                that.removeShow = false;
                            }else{
                                layer.msg(data.msg,{icon:2,time:2000});
                            }
                        })
                        .catch(function (error) {
                            console.log('error');
                        });
                    },
                    objectRemove:function(event){
                        this.type = event.srcElement.dataset.type;
                        this.removeProject.id = event.srcElement.dataset.id;
                        this.removeProject.index = event.srcElement.dataset.index;
                        this.removeShow = true;
                    },
                    objectUpdate:function(event){
                        this.type = event.srcElement.dataset.type;
                        var that = this;
                        this.createUrl = '{{ route('web.project.update') }}';
                        axios.get(this.getProject,{
                            params:{
                                project_id:event.srcElement.dataset.id
                            }
                        })
                        .then(function (response) {
                            var data = response.data;
                            if(data.status){
                                that.create = data.data;
                                that.createShow = true;
                            }else{
                                layer.msg(data.msg,{icon:2,time:2000});
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                    },
                    createShowEvent:function(event){
                        this.createUrl = '{{ route('web.project.create') }}';
                        this.createShow = true;
                        this.type = 1;
                    },
                    createParam:function(event){
                        this.create.param.push({});
                    },
                    removeParam:function(event){
                        var index = event.srcElement.dataset.index;
                        this.create.param.splice(index,1);
                        if(this.create.param.length == 0){
                            this.create.param.push({});
                        }
                    },
                    createProject:function(event){
                        var that = this;
                        var data = that.create;
                        that.isRequest = true;
                        if(!data.name){
                            that.isRequest = false;
                            return layer.msg('请输入项目名称',{icon:2,time:2000});
                        }
                        if(!data.brief){
                            that.isRequest = false;
                            return layer.msg('请输入项目简介',{icon:2,time:2000});
                        }
                        if(!data.brief){
                            that.isRequest = false;
                            return layer.msg('请输入项目简介',{icon:2,time:2000});
                        }
                        for(item in data.param){
                            if(!data.param[item].name){
                                that.isRequest = false;
                                return layer.msg('请输入环境标识',{icon:2,time:2000});
                            }
                            if(!data.param[item].title){
                                that.isRequest = false;
                                return layer.msg('请输入环境名称',{icon:2,time:2000});
                            }
                            if(!data.param[item].url || !CheckUrl(data.param[item].url)){
                                that.isRequest = false;
                                return layer.msg('请输入带http、https协议的环境地址',{icon:2,time:2000});
                            }
                        }
                        if(that.isRequest){
                            axios.get(this.createUrl,{
                                params:this.create
                            })
                            .then(function (response) {
                                var data = response.data;
                                if(data.status){
                                    created(that);
                                    that.createShow = false;
                                }else{
                                    layer.msg(data.msg,{icon:2,time:2000});
                                }
                            })
                            .catch(function (error) {
                                console.log('error');
                            });
                        }
                    }
                }
            });

            function eventApp(){
                // 拖拽排序
                var el = document.getElementById('sortable');
                var sortable = Sortable.create(el,{
                    animation: 150,
                    forceFallback: true,
                    handle: ".js_dragProjectBtn",
                    draggable: ".js_viewProject",
                    scrollSensitivity: 100,
                    scrollSpeed: 20
                });

                // 转让项目
                $(".js_transferProjectBtn").iframeModal({
                    modalItem: '#js_transferProjectModal', //modal元素
                    iframeItem: '#js_transferProjectIframe', //iframe元素
                    submitBtn: '.js_submit',
                });

                //查看项目
                $(".js_viewProject").click(function (event) {
                    event.stopPropagation();
                    window.location.href = $(this).data('url');
                });

            }

        });
    </script>
@endsection


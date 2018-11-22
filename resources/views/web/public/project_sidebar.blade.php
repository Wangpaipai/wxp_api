<div id="appModel">
    <div class="navbar-default sidebar" role="navigation" style="margin-top: 0;overflow: auto" :style="{height:domHeight - 45 + 'px'}">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ route('web.project.api.home',['id' => $project->id]) }}"><i class="fa fa-home fa-fw"></i> 项目主页</a>
                </li>

                <li v-if="group.is_update">
                    <a class="hidden-xs" data-id="{{ $project->id }}" @click="addModel" data-title="添加模块" href="javascript:void(0);"><i class="fa fa-fw fa-plus"></i> 添加模块</a>
                </li>

                {{--<li class="module-item js_moduleItem" v-for="(item,index) in menu" :data-id="item.id" :class="[model_id == item.id ? 'active' : '']">--}}
                <li class="module-item js_moduleItem active" v-for="(item,index) in menu" :data-id="item.id">
                    <a href="javascript:void(0);"><i class="fa fa-fw fa-folder-open"></i>
                        @{{ item.name }}

                        <span class="fa fa-fw arrow hidden"></span>
                        <span v-if="group.is_del" class="fa hidden-xs fa-fw fa-trash-o js_deleteModuleBtn hidden" @click="removeSet(item.id,index)" :data-id="item.id" title="删除模块"></span>
                        <span v-if="group.is_update" class="fa hidden-xs fa-fw fa-plus js_addApiBtn hidden" @click="apiCreate(item.id,index)" title="添加接口"></span>
                        <span v-if="group.is_update" @click="editModel(index)" class="fa hidden-xs fa-fw fa-pencil  js_addModuleBtn hidden" :data-id="item.id" title="编辑模块"></span>
                    </a>
                    <ul class="nav nav-second-level" :id="'api-menu-' + item.id" style="display: block">
                    {{--<ul class="nav nav-second-level" :id="'api-menu-' + item.id" :style="{display: model_id == item.id ? 'block' : 'none'}">--}}
                        <li class="api-item js_apiItem" v-for="value in item.api" @click="apiDetail(value.api_id)" :data-id="value.api_id">
                            <a href="javascript:;" :class="[api_id == value.api_id ? 'active' : '']" title="点击查看接口详情">
                                <i class="fa fa-fw fa-files-o"></i>@{{ value.title }}
                                <i class="fa fa-fw fa-eye pull-right hidden"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>

    <!-- 添加/编辑模块模态框 -->
    <div class="modal fade" id="js_addModuleModal" v-show="createShow" :class="{in:createShow}" style="display: block">
        <div class="modal-backdrop fade in" v-show="createShow" :style="{height:windowHeight + 'px'}"></div>
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="createShow = !createShow" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加模块</h4>
                </div>
                <div class="modal-body">
                    <div id="js_addProjectIframe" style="min-height: 380px;">
                        @include('web.module.add')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="createShow = !createShow" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" @click="createModel">提交</button>
                </div>

            </div>
        </div>

    </div>

    <!-- 添加接口模态框 -->
    <div class="modal fade" id="js_addApiModal" v-show="createApiShow" :class="{in:createApiShow}" style="display: block">
        <div class="modal-backdrop fade in" v-show="createApiShow" :style="{height:windowHeight + 'px'}"></div>
        <div class="modal-dialog" style="width: 700px;" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="createApiShow = !createApiShow" aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">添加接口</h4>
                </div>
                <div class="modal-body">
                    <div id="js_addProjectIframe" style="min-height: 380px;">
                        @include('web.api.add')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="createApiShow = !createApiShow" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" @click="addApi">提交</button>
                </div>

            </div>

        </div>

    </div>

    <!-- 删除模块模态框 -->
    <div class="modal fade" id="js_deleteModuleModal" v-show="delShow" :class="{in:delShow}" style="display: block">
        <div class="modal-backdrop fade in" v-show="delShow" :style="{height:windowHeight + 'px'}"></div>
        <div class="modal-dialog" role="document">
            <form role="form" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span @click="delShow = !delShow" aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">确定删除此模块吗？</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-dismissable alert-warning">
                            <i class="fa fa-fw fa-info-circle"></i>
                            模块删除后，该模块下所有接口也将被立刻删除，不可恢复，请谨慎操作！
                        </div>
                        <div class="form-group">
                            <input type="password" v-model="pwd" name='password' class="form-control" placeholder="重要操作，请输入登录密码" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" @click="delShow = !delShow" data-dismiss="modal">取消</button>
                        <button type="button" @click="modelRemove" class="btn btn-danger">删除</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>
</div>

@section('js')
    @parent
    <script src="{{ asset('static/plugins/sortable/sortable.min.js') }}"></script>
    <script>
        function getMenu(that){
            axios.get(that.menuListUrl,{
                params:{
                    project:that.project
                }
            })
            .then(function (response) {
                var data = response.data;
                if(data.status){
                    that.menu = data.data.menu;
                    that.group = data.data.group;
                }else{
                    layer.msg(data.msg,{icon:2,time:2000});
                }
            })
            .catch(function (error) {
                console.log(error);
            });
        }
        var menu = new Vue({
            el:'#appModel',
            data:{
                project:'{{ $project->id }}',
                createShow:false,
                windowHeight:0,
                domHeight:0,
                is_create:false,
                model:{
                    id:'',
                    name:''
                },
                modelType:'add',
                modelIndex:'',
                createModelUrl:'{{ route('web.project.model.create') }}',
                updateModelUrl:'{{ route('web.project.model.update') }}',
                getModelData:'{{ route('web.project.model.detail') }}',
                modelDel:'{{ route('web.project.model.remove') }}',
                pwd:'',
                removeModelId:'',
                removeIndex:'',
                menuListUrl:'{{ route('web.project.model.list') }}',
                menu:[],
                group:{},
                createApiShow:false,
                apiCreateData:{
                    method:'POST'
                },
                delShow:false,
                createApiUrl:'{{ route('web.project.api.create') }}',
                model_id:'{{ isset($api) ? $api->model_id : '' }}',
                api_id:'{{ isset($api) ? $api->id : '' }}'
            },
            created:function(){
                var that = this;
                that.windowHeight = window.innerHeight;
                that.domHeight = document.body.scrollHeight;
                getMenu(that);
            },
            methods:{
                apiDetail:function(api){
                    location.href = '/project/api/detail/' + api + '/' + this.project;
                },
                addApi:function(event){
                    var that = this;
                    var param = that.apiCreateData;
                    param.project_id = that.project;
                    if(!param.model_id){
                        return layer.msg('所属模块不存在',{icon:0,time:2000});
                    }
                    if(!param.title){
                        return layer.msg('接口名称不能为空',{icon:0,time:2000});
                    }
                    if(!param.url){
                        return layer.msg('请求地址不能为空',{icon:0,time:2000});
                    }
                    if(!param.method){
                        return layer.msg('请选择请求方式',{icon:0,time:2000});
                    }
                    axios.post(that.createApiUrl,param)
                    .then(function (response) {
                        var data = response.data;
                        if(data.status){
                            var api = {
                                api_id:data.data.id,
                                title:data.data.title
                            };
                            that.menu[param.index].api.push(api);
                            that.createApiShow = false;
                            layer.msg(data.msg,{icon:1,time:2000});
                        }else{
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                apiCreate:function(modelId,index){
                    this.apiCreateData.model_id = modelId;
                    this.apiCreateData.index = index;
                    this.apiCreateData.model_name = this.menu[index].name;
                    this.createApiShow = true;
                },
                removeSet:function(model,index){
                    this.removeModelId = model;
                    this.removeIndex = index;
                    this.delShow = true;
                },
                modelRemove:function(event){
                    var that = this;
                    axios.get(that.modelDel,{
                        params:{
                            id:that.removeModelId,
                            project:that.project,
                            pwd:that.pwd
                        }
                    })
                    .then(function (response) {
                        var data = response.data;
                        if(data.status){
                            that.menu.splice(that.removeIndex,1);
                            that.delShow = false;
                            layer.msg(data.msg,{icon:1,time:2000});
                        }else{
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                createModel:function(event){
                    var that = this;
                    if(!that.model.name){
                        return layer.msg('模块名不能为空',{icon:2,time:2000});
                    }
                    if(that.modelType === 'add'){
                        var url = that.createModelUrl;
                    }else{
                        var url = that.updateModelUrl;
                    }
                    that.model.project = that.project;
                    axios.get(url,{
                        params:that.model
                    })
                    .then(function (response) {
                        var data = response.data;
                        if(data.status){
                            that.createShow = false;
                            layer.msg(data.msg,{icon:1,time:2000});
                            if(that.modelType === 'add'){
                                that.menu.push({
                                    id:data.data.id,
                                    name:data.data.name,
                                    api:[]
                                });
                            }else{
                                that.menu[that.modelIndex].name = that.model.name;
                            }
                        }else{
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                editModel:function(index){
                    var that = this;
                    var modelData = this.menu[index];
                    that.modelIndex = index;
                    that.model.id = modelData.id;
                    that.model.name = modelData.name;
                    that.modelType = 'update';
                    that.createShow = true;
                    that.is_create = false;
                },
                addModel:function(){
                    this.modelType = 'add';
                    this.createShow = true;
                    this.is_create = true;
                    this.model = {};
                }
            }
        })
    </script>
    <script>

        $("#appModel").on('mouseover','.js_moduleItem',function(event){
            event.stopPropagation();
            $(this).find('span').removeClass('hidden');
            $('.js_apiItem').find('span').addClass('hidden');

        }).mouseout(function(event){
            event.stopPropagation();
            $(this).find('span').addClass('hidden');

        });

        $("#appModel").on('mouseover','.js_apiItem',function(event){
            event.stopPropagation();
            $(this).find('span').removeClass('hidden');
            $(this).find('.fa-eye').removeClass('hidden');

        }).mouseout(function(event){
            event.stopPropagation();
            $(this).find('span').addClass('hidden');
            $(this).find('.fa-eye').addClass('hidden');
        });

        $("#appModel").on('click','.js_moduleItem',function(event){
            event.stopPropagation();
            if($(this).hasClass('active')){
                $(this).children('ul').fadeOut();
                $(this).removeClass('active');
            }else{
                $(this).children('ul').fadeIn();
                $(this).addClass('active');
            }
        })
        $("#appModel").on('click','.js_deleteModuleBtn ',function(event){
            event.stopPropagation();
            return false;
        })
        $("#appModel").on('click','.js_addApiBtn ',function(event){
            event.stopPropagation();
            return false;
        })
        $("#appModel").on('click','.js_addModuleBtn ',function(event){
            event.stopPropagation();
            return false;
        })
        $("#appModel").on('click','.js_apiItem ',function(event){
            event.stopPropagation();
            return false;
        })
    </script>
@endsection
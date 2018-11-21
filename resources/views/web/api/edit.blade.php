@extends('web.public.app')
@section('title', '接口详情')

@section('css')
    <link href="{{ asset('static/plugins/jsonFormat/css.css') }}" rel="stylesheet" type="text/css">
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
        <div id="page-wrapper">
            <form role="form" method="post">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-header">
                            <h1>接口编辑</h1>
                            <div class="opt-btn">
                                <a class="btn btn-sm btn-success js_submit" @click="updateApi" href="javascript:void(0);"><i class="fa fa-fw fa-save"></i>保存</a>
                                <a class="btn btn-sm btn-warning" href="{{ route('web.project.api.detail',['id' => $api_id,'project' => $project->id]) }}"><i class="fa fa-fw fa-reply"></i>取消</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                接口详情
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="form-group">
                                            <label>接口名称</label>
                                            <input class="form-control" v-model="api.title" value="" placeholder="必填">
                                        </div>

                                        <div class="form-group">
                                            <label>所属分类</label>
                                            <select v-model="api.model_id" class="form-control">
                                                @foreach($model as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">请求类型</label>
                                            <div class="form-group">
                                                <label class="radio-inline">
                                                    <input type="radio" v-model="api.method" value="GET"> GET
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" v-model="api.method" value="POST"> POST
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" v-model="api.method" value="PUT"> PUT
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" v-model="api.method" value="DELETE"> DELETE
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>接口路径

                                            </label>

                                            <input class="form-control" v-model="api.url"  value="" placeholder="必填，不包含域名部分">

                                        </div>

                                        <div class="form-group">
                                            <label>接口描述</label>
                                            <textarea class="form-control" v-model="api.brief"  rows="3" placeholder="非必填" ></textarea>
                                        </div>

                                    </div>
                                    <!-- /.col-lg-6 (nested) -->

                                    <!-- /.col-lg-6 (nested) -->
                                </div>

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!-- /.row -->
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Haader参数
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">

                                    <div class="panel-header">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr class="success">

                                                <th>字段键</th>
                                                <th>字段值</th>
                                                <th>备注说明</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in api.header">
                                                <td>
                                                    <input class="form-control" v-model="item.key"/>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.value"/>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.remark"/>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" @click="createNextHeader(index)" class="fa fa-plus  btn btn-sm btn-default"></a>
                                                    <a href="javascript:void(0);" @click="removeHeader(index)" class="fa fa-trash-o btn btn-sm btn-default"></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <button type="button" @click="addHeader" class="btn btn-default"><i class="fa fa-fw fa-plus"></i>添加参数</button>
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                请求参数
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">

                                    <div class="panel-request">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr class="success">

                                                <th>字段别名</th>
                                                <th>字段含义</th>
                                                <th>字段类型</th>
                                                <th style="width: 10%">是否必填</th>
                                                <th>默认值</th>
                                                <th>备注说明</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in api.param">
                                                <td>
                                                    <input class="form-control" v-model="item.name"/>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.brief"/>
                                                </td>
                                                <td>
                                                    <select v-model="item.type" class="form-control">
                                                        <option value="null">null</option>
                                                        <option value="string">string</option>
                                                        <option value="json">json</option>
                                                        <option value="number">number</option>
                                                        <option value="float">float</option>
                                                        <option value="boolean">boolean</option>
                                                        <option value="array">array</option>
                                                        <option value="object">object</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select v-model="item.must" class="form-control">
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.default"/>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.remark"/>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" @click="createNextParam(index)" class="fa fa-plus  btn btn-sm btn-default"></a>
                                                    <a href="javascript:void(0);" @click="removeParam(index)" class="fa fa-trash-o btn btn-sm btn-default"></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <button @click="addParam" type="button" class="btn btn-default"><i class="fa fa-fw fa-plus"></i>添加参数</button>
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                响应参数
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <div class="panel-response">

                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr class="success">
                                                <th>字段名</th>
                                                <th>字段含义</th>
                                                <th>字段类型</th>
                                                <th>备注说明</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in api.response">
                                                <td>
                                                    <input class="form-control" v-model="item.name"/>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.brief"/>
                                                </td>
                                                <td>
                                                    <select v-model="item.type" class="form-control">
                                                        <option value="null">null</option>
                                                        <option value="string">string</option>
                                                        <option value="json">json</option>
                                                        <option value="number">number</option>
                                                        <option value="float">float</option>
                                                        <option value="boolean">boolean</option>
                                                        <option value="array">array</option>
                                                        <option value="object">object</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" v-model="item.remark"/>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" @click="createNextResponse(index)" class="fa fa-plus  btn btn-sm btn-default"></a>
                                                    <a href="javascript:void(0);" @click="removeResponse(index)" class="fa fa-trash-o btn btn-sm btn-default"></a>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <button @click="addResponse" type="button" class="btn btn-default"><i class="fa fa-fw fa-plus"></i>添加参数</button>
                                    </div>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                返回示例（JSON字符串,不要格式化）
                            </div>
                            <div class="panel-body">
                                <div class="json-box">
                                    <textarea v-model="api.case" class="form-control"></textarea>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="page-header">
                                <div class="opt-btn">
                                    <a class="btn btn-sm btn-success js_submit" @click="updateApi" href="javascript:void(0);"><i class="fa fa-fw fa-save"></i>保存</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.col-lg-6 -->
                </div>

            </form>
        </div>
        @include('web.public.record')
    </div>
@endsection

@section('js')
    <script>
        function arrayNullCheck(arr){
            for(item in arr.header){
                if(JSON.stringify(arr.header[item]) === '{}'){
                    layer.msg('Header参数不能为空',{icon:0,time:2000});
                    return false;
                }
            }
            for(item in arr.param){
                if(JSON.stringify(arr.param[item]) === '{}'){
                    layer.msg('请求参数不能为空',{icon:0,time:2000});
                    return false;
                }
            }
            for(item in arr.response){
                if(JSON.stringify(arr.response[item]) === '{}'){
                    layer.msg('响应参数不能为空',{icon:0,time:2000});
                    return false;
                }
            }
            return true;
        }
        var app = new Vue({
            el:'#wrapper',
            data:{
                project:'{{ $project->id }}',
                api_id:'{{ $api_id }}',
                api:{},
                getApiUrl:'{{ route('web.project.api.getDetail') }}',
                updateUrl:'{{ route('web.project.api.update') }}'
            },
            created:function(){
                var that = this;
                axios.get(that.getApiUrl,{
                    params:{
                        project:that.project,
                        api:that.api_id
                    }
                })
                .then(function (response) {
                    var data = response.data;
                    if(data.status){
                        that.api = data.data;
                    }else{
                        layer.msg(data.msg,{icon:2,time:2000});
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            methods:{
                updateApi:function(event){
                    var that = this;
                    var api = that.api;
                    var check = arrayNullCheck(api);
                    if(!check){
                        return false;
                    }
                    axios.post(that.updateUrl,api)
                    .then(function (response) {
                        var data = response.data;
                        if(data.status){
                            layer.msg(data.msg,{icon:1,time:2000});
                            setTimeout(function(){
                                location.href = '{{ route('web.project.api.detail',['id' => $api_id,'project' => $project->id]) }}';
                            },1000)
                        }else{
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                removeResponse:function(index){
                    this.api.response.splice(index,1);
                },
                removeParam:function(index){
                    this.api.param.splice(index,1);
                },
                removeHeader:function(index){
                    this.api.header.splice(index,1);
                },
                createNextHeader:function(index){
                    this.api.header.splice(index+1,0,{});
                },
                createNextParam:function(index){
                    this.api.param.splice(index+1,0,{});
                },
                createNextResponse:function(index){
                    this.api.response.splice(index+1,0,{});
                },
                addHeader:function(event){
                    this.api.header.push({});
                },
                addParam:function(event){
                    this.api.param.push({});
                },
                addResponse:function(event){
                    this.api.response.push({});
                }
            }
        })
    </script>
@endsection
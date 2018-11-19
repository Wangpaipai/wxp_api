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
                        <h1>项目主页 </h1>
                        <div class="opt-btn">
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
                            <p class="text-muted"><label>项目名称：</label>{{ $project->name }}</p>
                            <p class="text-muted"><label>项目创建人：</label>{{ $project->username }}</p>
                            <p class="text-muted"><label>搜索状态：</label>{{ $project->is_show ? '可搜索' : '禁止搜索' }}</p>
                            <p class="text-muted"><label>创建时间：</label>{{ $project->created_at }}</p>
                            <p class="text-muted"><label>更新时间：</label>{{ $project->updated_at }}</p>

                            <p class="text-muted"><label>项目描述：</label><span style="word-break:break-all">{{ $project->brief }}</span></p>
                            <p class="text-muted"><label>环境域名：</label>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>环境标识符</th>
                                        <th>标识符备注</th>
                                        <th>环境域名</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($project->param as $value)
                                    <tr>
                                        <td>{{ $value['name'] }}</td>
                                        <td>{{ $value['title'] }}</td>
                                        <td><code>{{ $value['url'] }}</code></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            </p>
                        </div>
                    </div>
                </div>
                @include('web.public.record')
            </div>
        </div>
    </div>

    <hr>
@endsection

@section('js')
    <script src="{{ asset('static/plugins/sortable/sortable.min.js') }}"></script>

    <script>
        $(function(){

            //添加/编辑模块表单合法性验证
            $("#js_addModuleForm").validateForm();

            // 添加/编辑模块
            $(".js_addModuleBtn").iframeModal({
                clickItem: '.js_addModuleBtn', //modal元素
                modalItem: '#js_addModuleModal', //modal元素
                iframeItem: '#js_addModuleIframe', //提交按钮
                submitBtn: '.js_submit'
            });

            //删除模块表单合法性验证
            $("#js_deleteModuleModal form").validateForm();

            // 删除模块
            $(".js_deleteModuleBtn").click(function () {
                // 阻止事件冒泡
                event.stopPropagation();
                var id = $(this).data('id');

                if(id <= 0){
                    alert('请选择要删除的模块');
                }

                $('#js_deleteModuleModal input[name=id]').val(id);

                $('#js_deleteModuleModal').modal('show');
            });

            // 添加/编辑接口
            $(".js_addApiBtn").iframeModal({
                clickItem: '.js_addApiBtn', //modal元素
                modalItem: '#js_addApiModal', //modal元素
                iframeItem: '#js_addApiIframe', //提交按钮
                submitBtn: '.js_submit'
            });

            $(".js_moduleItem").mouseover(function(event){
                event.stopPropagation();
                $(this).find('span').removeClass('hidden');
                $('.js_apiItem').find('span').addClass('hidden');

            }).mouseout(function(event){
                event.stopPropagation();
                $(this).find('span').addClass('hidden');

            });

            $(".js_apiItem").mouseover(function(event){
                event.stopPropagation();
                $(this).find('span').removeClass('hidden');
                $(this).find('.fa-eye').removeClass('hidden');

            }).mouseout(function(event){
                event.stopPropagation();
                $(this).find('span').addClass('hidden');
                $(this).find('.fa-eye').addClass('hidden');

            });

        });
    </script>
@endsection
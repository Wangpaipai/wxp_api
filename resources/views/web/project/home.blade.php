@extends('web.public.app')
@section('title', '项目主页')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div id="wrapper">

        <!-- Navigation -->
        @include('web.public.nav')
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
                            <p class="text-muted"><label>项目名称：</label></p>
                            <p class="text-muted"><label>项目创建人：</label></p>
                            <p class="text-muted"><label>搜索状态：</label></p>
                            <p class="text-muted"><label>创建时间：</label></p>
                            <p class="text-muted"><label>更新时间：</label></p>

                            <p class="text-muted"><label>项目描述：</label><span style="word-break:break-all"></span></p>
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
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><code></code></td>
                                    </tr>

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
@endsection
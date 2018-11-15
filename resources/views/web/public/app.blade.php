<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=0">
    <title>王丨小牌API管理系统 - @yield('title')</title>
    <link href="{{ asset('static/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/plugins/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('static/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/plugins/validform/css.css') }}" rel="stylesheet">
    <style>
        @media(min-width:768px) {
            .sidebar {
                z-index: 1;
                position: absolute;
                width: 250px;
                margin-top: 51px;
            }

            .navbar-top-links .dropdown-messages,
            .navbar-top-links .dropdown-tasks,
            .navbar-top-links .dropdown-alerts {
                margin-left: auto;
            }
        }

        @media(min-width:768px) {
            #page-wrapper {
                position: inherit;
                margin: 0;
                padding: 0 30px;
                border-left: 1px solid #e7e7e7;
            }
        }

    </style>
    @yield('css')
</head>

<body>

@yield('content')
        <!-- 修改个人资料模态框 -->
@if(isset($user))
    <div class="modal fade" id="js_settingProfileModal" tabindex="-1" role="dialog" aria-labelledby="settingLabel" aria-hidden="true">
        <form id="js_settingProfileForm" role="form" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="settingLabel">个人设置</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <label>登录邮箱</label>
                                    <input name="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label>用户昵称</label>
                                    <input name="name" class="form-control" value="{{ $user->name }}" disabled type="text" />
                                </div>

                                <div class="form-group">
                                    <label>原密码</label>
                                    <input class="form-control" placeholder="" v-model="ypwd" name="ypassword" type="password" maxlength="20">
                                </div>

                                <div class="form-group">
                                    <label>新密码</label>
                                    <input class="form-control" placeholder="修改密码需要重新登录，密码不少于6位" v-model="password" name="password" type="text" maxlength="20">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" @click="pwdUpdate" class="btn btn-primary">保存</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>
@endif
</body>
{{--<script src="{{ asset('static/js/html5shiv.js') }}"></script>--}}
{{--<script src="{{ asset('static/js/respond.min.js') }}"></script>--}}
<script src="{{ asset('static/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('static/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('static/plugins/metisMenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('static/plugins/validform/v5.3.2_min.js') }}"></script>
<script src="{{ asset('static/plugins/validform/datatype.js') }}"></script>
<script src="{{ asset('static/plugins/artDialog/dist/dialog.js') }}"></script>
<script src="{{ asset('static/js/common.js') }}"></script>
<script src="{{ asset('static/js/layer.js') }}"></script>
<script src="{{ asset('static/js/app.js') }}"></script>
<script src="{{ asset('static/js/vue.min.js') }}"></script>
<script src="{{ asset('static/js/axios.min.js') }}"></script>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?daf0d8924deff98ade7d56994ec572d8";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<script>
    var wxp = new Vue({
        el:'#js_settingProfileForm',
        data:{
            ypwd:'',
            password:'',
            editPwdUrl:'{{ route('web.password.update') }}'
        },
        methods:{
            pwdUpdate:function(event){
                var that = this;
                if(that.password.length < 6 || that.password.length > 20){
                    return layer.msg('请输入6-20位密码',{icon:0,time:2000});
                }
                axios.get(that.editPwdUrl,{
                    params:{
                        ypwd:that.ypwd,
                        password:that.password
                    }
                })
                .then(function (response) {
                    var data = response.data;
                    if(data.status){
                        that.ypwd = '';
                        that.password = '';
                        location.href = '{{ route('web.index') }}';
                    }else{
                        layer.msg(data.msg,{icon:2,time:2000});
                    }
                })
                .catch(function (error) {
                    console.log('error');
                });
            }
        }
    })
</script>
@yield('js')
</html>





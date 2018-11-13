@extends('web.public.app')
@section('title', '用户登录')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">用户登录</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="js_loginForm" method="get">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" v-model="user.username" placeholder="登录用户名/邮箱" name="username" type="email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" v-model="user.password" placeholder="登录密码" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">

                                        <input type="text" v-model="user.code" @keyup.enter="loginCheck" name="code" class="form-control">

                                        <a class="input-group-btn verify-code">

                                            <img alt="点击刷新" title="点击刷新" id="checkCode" @click="reloadCap" :src="captcha">

                                        </a>

                                    </div>

                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0);" @click="loginCheck" class="btn btn-lg btn-success btn-block js_submit">立即登录</a>

                                <hr>

                                <a href="{{ route('web.register') }}" class="btn btn-default btn-block">还没有账号？免费注册</a>

                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <hr>
        @include('web.public.record')
    </div>
@endsection
@section('js')
    <script>
        function checkForm(data){
            if(!data.username){
                layer.msg('请输入正确用户名',{icon:0,time:2000});
                return false;
            }

            if(data.password.length < 6 || data.password.length > 20){
                layer.msg('请输入6-20位登录密码',{icon:0,time:2000});
                return false;
            }

            if(data.code.length != 4){
                layer.msg('请输入4位验证码',{icon:0,time:2000});
                return false;
            }
            return true;
        }

        var app = new Vue({
            el:'#js_loginForm',
            data:{
                user:{
                    username:'',
                    password:'',
                    code:''
                },
                requestUrl:'{{ route('web.login.loginCheck') }}',
                succUrl:'{{ route('web.index') }}',
                captcha:'{{ captcha_src() }}'
            },
            methods:{
                loginCheck:function(event){
                    var that = this;
                    if(checkForm(this.user)){
                        axios.get(this.requestUrl,{
                            params:this.user
                        })
                        .then(function (response) {
                            var data = response.data;
                            if(data.status){
                                alert(that.succUrl);
                                location.href = that.succUrl;
                            }else{
                                $('#checkCode').attr('src','{{ captcha_src() }}' + '?' + Math.random());
                                layer.msg(data.msg,{icon:2,time:2000});
                            }
                        })
                        .catch(function (error) {
                            console.log('error');
                        });
                    }
                },
                reloadCap:function(event){
                    this.captcha = this.captcha + '?' + Math.random();
                }
            }
        })
    </script>
@endsection
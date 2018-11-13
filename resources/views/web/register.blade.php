@extends('web.public.app')
@section('title', '用户注册')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">用户注册</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="js_regForm" action="" method="post">

                            <fieldset>
                                <div class="form-group">
                                    <input id="auto-complete-email" class="form-control" placeholder="登录邮箱，必填" name="email" type="text" >
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="用户昵称，必填，建议写真实姓名以方便识别" name="name" type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="登录密码，6-20位" name="password" type="password">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="确认密码" name="repassword" type="password">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="code" class="form-control" datatype="*" placeholder="验证码，不区分大小写">
                                        <a class="input-group-btn verify-code">
                                            <img alt="点击刷新" title="点击刷新" onclick="this.src='{{ captcha_src() }}' + '?' + Math.random()" id="checkCode" src="{{ captcha_src() }}">
                                        </a>
                                    </div>
                                </div>
                                <button type="button" href="javascript:void(0);" data-succ="{{ route('web.login') }}" data-url="{{ route('web.register.registerCheck') }}" class="btn btn-lg btn-success btn-block js_submit">快速注册</button>
                                <hr>
                                <a href="{{ route('web.login') }}" class="btn btn-default btn-block">已有账号，直接登录</a>

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
    var is_request = true;
    var err_msg = '';

    $('input[name=email]').change(function(){
        var that = $(this);
        var email = $(this).val();
        $.ajax({
            type:"get",
            dataType:"json",
            url:'{{ route('web.register.isExistence') }}',
            data:{
                email:email
            },
            success:function(data){
                if(!data.status){
                    that.addClass('Validform_error');
                    is_request = false;
                    err_msg = '邮箱已存在';
                    layer.msg(err_msg,{icon:2,time:2000});
                }else{
                    that.removeClass('Validform_error');
                    is_request = true;
                }
            }
        });
    })

    $('input[name=name]').change(function(){
        var that = $(this);
        var name = $(this).val();
        $.ajax({
            type:"get",
            dataType:"json",
            url:'{{ route('web.register.isExistence') }}',
            data:{
                name:name
            },
            success:function(data){
                if(!data.status){
                    that.addClass('Validform_error');
                    is_request = false;
                    err_msg = '该用户名已存在';
                    layer.msg(err_msg,{icon:2,time:2000});
                }else{
                    that.removeClass('Validform_error');
                    is_request = true;
                }
            }
        });
    })

    function checkForm(){
        if(!checkEmail($('input[name=email]').val())){
            layer.msg('请输入正确的邮箱',{icon:0,time:2000});
            return false;
        }
        var nameLen = $('input[name=name]').val().length;
        if(nameLen < 2 || nameLen > 10){
            layer.msg('请输入由2-10个字母或汉字组成的昵称',{icon:0,time:2000});
            return false;
        }
        var password = $('input[name=password]').val();
        var pwd = $('input[name=repassword]').val();
        if(password.length < 6 || password.length > 20){
            layer.msg('请输入6-20位登录密码',{icon:0,time:2000});
            return false;
        }

        if(password != pwd){
            layer.msg('两次密码不一致',{icon:0,time:2000});
            return false;
        }

        if($('input[name=code]').val().length != 4){
            layer.msg('请输入4位验证码',{icon:0,time:2000});
            return false;
        }
        return true;
    }

    $('.js_submit').click(function(){
        var that = $(this);
        var data = $('#js_regForm').serialize();
        var url = $(this).attr('data-url');
        var succ = $(this).attr('data-succ');

        if(is_request){
            if(checkForm()){
                that.attr('disabled',true);
                $.ajax({
                    type:"get",
                    dataType:"json",
                    url:url,
                    data:data,
                    success:function(data){
                        that.removeAttr('disabled');
                        if(data.status){
                            layer.msg(data.msg,{icon:1,time:2000});
                            setTimeout(function(){
                                location.href = succ;
                            },2000)
                        }else{
                            $('#checkCode').attr('src','{{ captcha_src() }}' + '?' + Math.random());
                            layer.msg(data.msg,{icon:2,time:2000});
                        }
                    }
                });
            }
        }else{
            layer.msg(err_msg,{icon:2,time:2000});
        }
    })
</script>
@endsection

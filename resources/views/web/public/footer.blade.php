


<script>
    $(function(){

        // 判断是否是默认密码
        var isDefaultPassword = "{{is_default_password()}}";

        if(isDefaultPassword){

            confirm('您的密码是默认密码，为安全起见，请立即修改密码', function(){

                $('#js_settingProfileModal').modal('show');

            });
        }

        //退出登录
        $(document).delegate('.js_logoutBtn', 'click',function(){

            var url = "{{url('logout','','','json')}}";

            $.post(url, {}, function(json){

                if(json.code == 200){

                    alert(json.msg, 800, function(){

                        window.location.href = "{{url('login')}}";

                    });
                }

            }, 'json');
        });

        // 关闭单条消息
        $(document).delegate('.js_cleanSingleNotify', 'click',function(event){
            event.stopPropagation();

            var thisObj = $(this);

            var id  = thisObj.data('id');

            var url = "{{url('notify/delete')}}";

            $.post(url, { id:id }, function(json){

                if(json.code == 200){

                    alert(json.msg, 1000, function(){

                        thisObj.closest('li').remove();

                        var url = "{{url('notify/load')}}";
                        $('.js_notifyDropdown').load(url);

                    });

                }else{

                    alert(json.msg, 3000);

                }

            }, 'json');

        });

        // 清空全部消息
        $(document).delegate('.js_cleanAllNotify', 'click',function(){
            confirm('确定要清空所有的提醒消息?', function(){
                var ids = '';
                $(".js_cleanSingleNotify").each(function () {

                    ids += $(this).data('id') + ',';

                });

                var url = "{{url('notify/delete')}}";

                $.post(url, { id:ids }, function(json){

                    if(json.code == 200){

                        alert(json.msg, 1000, function(){

                            var url = "{{url('notify/load')}}";
                            $('.js_notifyDropdown').load(url);

                        });

                    }else{

                        alert(json.msg, 3000);

                    }

                }, 'json');

                //alert('提醒消息清理成功', 500);

            });

        });

        //修改个人资料表单验证
        $("#js_settingProfileForm").validateForm();

        // ajax消息通知
        {{if get_config('is_push')}}

        var loadUrl = "{{url('notify/load')}}";
        var pushTime = "{{get_config('push_time')}}";

        setInterval(function(){

            $('.js_notifyDropdown').load(loadUrl);

        }, pushTime*1000);
        {{/if}}

    });
</script>

</body>

</html>
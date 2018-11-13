{{include_file name='public/header' title='消息提示'}}

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

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    {{include_file name='public/nav'}}
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">消息提示</h1>
                <div class="search">
                    <div class="well">
                        <h4>
                            {{if $type == 'error'}}
                            <i class="fa fa-times-circle fa-fw"></i>
                            {{else}}
                            <i class="fa fa-check-circle fa-fw"></i>
                            {{/if}}
                            {{$content}}</h4>
                        {{if $url}}
                        <a href="{{$url}}">点击此处跳转</a>
                        {{else}}
                        <a href="javascript:history.back();">返回上一页</a>
                        {{/if}}
                        （<em id="jumpTime">{{$time}}</em>秒后自动跳转）
                    </div>
                </div>
            </div>




            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <!-- /#page-wrapper -->



    </div>

    <!-- /#wrapper -->

        <script type="text/javascript">
            var time = $("#jumpTime").text();
            var url  = "{{$message.url}}";
            if(!url){
                url = "javascript:history.back()";
            }
            var jumpInterval = setInterval(function(){
                time--;
                if (time < 1) time = 1;
                $("#jumpTime").text(time);
                if (time == 1) {
                    clearInterval(jumpInterval);
                    window.location.href = url;
                }
            }, 1000);
        </script>


    {{include_file name='public/footer'}}

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
@yield('js')
</html>





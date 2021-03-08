<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('admin/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <!-- <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
    <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin/js/custom.js')}}"></script>
    <style>
    
        .login_admin {
            border-radius: 1px !important;
            font-size: 18px;
            width: 400px;
            color: #a506a4;
            border: 2px solid #bb07bb;
            background-color: transparent;

        }

        .login_admin:hover {
            background-color: #bb07bb;
            border: 2px solid grey;
            color: #fff;
        }

        .login_admin:focus {
            background-color: #bb07bb;
            border: 2px solid grey;
            color: #fff;
        }
    </style>

</head>

<body>
    <div class="container" style="margin-top:5%">
        <div class="col-md-3 offset-md-5 mb-3">
            <img src="{{asset('admin/images/login.png')}}" style="width:100px" class="mr-3"><span class="moto"> OLFT ADMIN <span>
        </div>
        <div class="col-md-6 offset-md-3 ">
            <div class="card card-info">
                @yield('content')
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#flashMessage").slideUp(1000);
            }, 3000);
        });
    </script>
</body>

</html>
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
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <style>
    .span-info {
      background-color: rgb(178, 224, 116);
      padding: 5px;
      border-radius: 4px;
    }

    .span-warning {
      background-color: yellow;
      padding: 5px;
      border-radius: 4px;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>

      </ul>


      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
            <!-- <span class="badge badge-warning navbar-badge">15</span> -->
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-edit"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{route('admin.logout')}}" class="dropdown-item">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{route('admin.dashboard')}}" class="brand-link">
        <img src="{{asset('admin/images/logo-png.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Online Training</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('admin/images/user.png')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">User Name</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open">
              <a href="{{route('admin.dashboard')}}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  <!-- Dashboard -->
                  ダッシュボード
                </p>
              </a>

            </li>

            <li class="nav-item">
              <a href="{{route('admin.schedule.management.view')}}" class="nav-link">
                <!-- <i class="nav-icon far fa-image"></i> -->
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                  <!-- Schecdule Management -->
                  スケジュール管理
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{route('admin.user.management.view')}}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  <!-- User Management -->
                  ユーザー管理
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.user.management.view')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>list</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('purchase.plan.list')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      購入を計画する
                      <!-- Plan Purchase -->
                    </p>
                  </a>
                </li>

              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <!-- <i class="nav-icon far fas fa-money"></i> -->
                <i class=" nav-icon fas fa-money-bill-alt"></i>
                <p>
                  <!-- Payment -->
                  支払い
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <!-- <i class="nav-icon far fa-image"></i> -->
                <i class=" nav-icon fas fa-cloud-download-alt"></i>
                <p>
                  <!-- Data Download -->
                  データのダウンロード
                </p>
              </a>
            </li>


            <li class="nav-item">
              <a href="{{route('admin.setting')}}" class="nav-link">
                <i class="nav-icon far fas fa-user"></i>
                <p>
                  <!-- Admin User -->
                  管理者ユーザー

                </p>
                <i class="right fas fa-angle-left"></i>

              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.list')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      <!-- list -->
                      リスト
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.add')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      <!-- add -->
                      追加
                    </p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="{{route('admin.setting')}}" class="nav-link">
                <i class="nav-icon far fas fa-cog"></i>
                <p>
                  <!-- Setting/ Master Data -->
                  設定
                </p>
                <i class="right fas fa-angle-left"></i>

              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.setting')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>セットアップデータ</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.equipment.list')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>設備</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{route('trainer.list')}}" class="nav-link">
                <!-- <i class="nav-icon far fa-image"></i> -->
                <i class=" nav-icon fas fa-tasks"></i>
                <p>
                  <!-- Admin Trainer Manage -->
                  管理トレーナー管理
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('user.list')}}" class="nav-link">
                <!-- <i class="nav-icon far fa-image"></i> -->
                <i class=" nav-icon fas fa-tasks"></i>
                <p>
                  <!-- User Trainer Manage -->
                  ユーザートレーナー管理
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('course.list')}}" class="nav-link">
                <!-- <i class="nav-icon far fa-image"></i> -->
                <i class=" nav-icon fas fa-tasks"></i>
                <p>
                  <!-- Courses -->
                  コース
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <!-- <h1 class="m-0 text-dark">Dashboard</h1> -->
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">@yield('pageName')</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        @yield('content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2020-2021 <a href="#">Lorem Ipsum</a>.</strong>
      All rights reserved.

    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('admin/plugins/sparklines/sparkline.js')}}"></script>
  <!-- JQVMap -->
  <script src="{{asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- DataTables -->
  <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('admin/dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('admin/dist/js/demo.js')}}"></script>

  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
    $(document).ready(function() {
      setTimeout(function() {
        $("#flashMessage").slideUp(1000);
      }, 3000);
    });
  </script>
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


</body>

</html>
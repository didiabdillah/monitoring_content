<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" type="ico" href="{{URL::asset('assets/img/favicon.ico')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/select2/css/select2.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('assets/css/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{URL::asset('assets/css/adminlte.css')}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item"></li>
                <li class="nav-item">
                    <h4 class="mt-1 ml-3">@yield('title')</h4>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge" style="margin-top: -7px;">999+</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">999+ Notifications</span>
                        <div class="direct-chat-messages" style="height: 200px;">
                            @for($i=0; $i<10; $i++) <div class="dropdown-divider">
                        </div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <div class="media-body">
                                    <p class="dropdown-item-title">
                                        Hardwired Hardwired Hardwired
                                    <p class="text-sm text-muted float-right"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </p>
                                    <p class="text-sm">Finish Your Task </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        @endfor
                    </div>

                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>

    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <img src="{{URL::asset('assets/img/profile/' . Session::get('user_image'))}}" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline">{{Str::words(Session::get('user_name'), 3)}}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <!-- User image -->
            <li class="user-header bg-primary">
                <img src="{{URL::asset('assets/img/profile/' . Session::get('user_image'))}}" class="img-circle elevation-2" alt="User Image">
                <p>
                    {{Str::words(Session::get('user_name'), 3)}}
                    <small>{{Session::get('user_email')}}</small>
                </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                <a href="{{route('profile', 'me')}}" class="btn btn-default btn-flat">Profile</a>
                <a href="{{route('logout')}}" class="btn btn-default btn-flat float-right">Sign out</a>
            </li>
        </ul>
        </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{url('/')}}" class="brand-link">
                <img src="{{URL::asset('assets/img/icon-white.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1">
                <span class="brand-text font-weight-light">UProject</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{URL::asset('assets/img/profile/' . Session::get('user_image'))}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{route('profile', 'me')}}" class="d-block">{{Str::words(Session::get('user_name'), 3)}}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-header">USER MENU</li>
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link @if(Request::segment(1) == 'home') {{'active'}} @endif">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('project')}}" class="nav-link @if(Request::segment(1) == 'project' || Request::segment(2) == 'project') {{'active'}} @endif">
                                <i class="nav-icon fas fa-project-diagram"></i>
                                <p>
                                    Project
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('user_page')

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block" style="margin-top: -13px;">
                <b>Copyright &copy; {{date('Y')}} UProject </b>All rights reserved.
            </div>

        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{URL::asset('assets/js/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{URL::asset('assets/js/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{URL::asset('assets/js/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- DataTables  & Plugins -->
        <script src="{{URL::asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
        <!-- bs-custom-file-input -->
        <script src="{{URL::asset('assets/js/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{URL::asset('assets/js/adminlte.min.js')}}"></script>
        <!-- Sweet Alert -->
        <script src="{{URL::asset('assets/js/sweetalert2/sweetalert2.all.min.js')}}"></script>
        <!-- Select2 -->
        <script src="{{URL::asset('assets/js/select2/js/select2.full.min.js')}}"></script>
        <!-- Own Script -->
        <script src="{{URL::asset('assets/js/ScriptSweetalert2.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{URL::asset('assets/js/demo.js')}}"></script>
        <!-- Page specific script -->

        <script>
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "pagingType": "simple_numbers",
                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                // make a function to scroll down auto
                $('.discussion').animate({
                    scrollTop: $('.discussion').get(0).scrollHeight
                }, 1000);


                bsCustomFileInput.init();
            });
        </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- CODE SETTING FAVICON DAN LOGO JANGAN DI UBAH -->
    @php
    $setting = DB::table('settings')->where('setting_id', 1)->first();
    $favicon = ($setting) ? $setting->setting_favicon : 'default-favicon.ico';
    $logo = ($setting) ? $setting->setting_logo : 'default-logo.png';
    @endphp

    <!-- CODE SETTING FAVICON DAN LOGO JANGAN DI UBAH -->
    <!-- Favicon -->
    <link rel="icon" type="ico" href="{{URL::asset('assets/img/favicon/' . $favicon)}}">

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

    @stack('style')
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

                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{route('notification')}}">
                        <i class="far fa-bell fa-lg" style="margin-right: 5px;"></i>
                        @php
                        $unread = App\Models\Notification::orderBy('notification_date', 'desc')->where('notification_user_id', Session::get('user_id'))->where('notification_status', 0)->count();
                        @endphp
                        @if( $unread != 0)
                        <span class="badge badge-warning navbar-badge" style="margin-top: -7px; font-size: 12pt;">

                            @if($unread > 99)
                            99+
                            @else
                            {{$unread}}
                            @endif

                        </span>
                        @endif
                    </a>
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
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{url('/home')}}" class="brand-link">
                <img src="{{URL::asset('assets/img/logo/' . $logo)}}" alt="" class="brand-image img-circle elevation-3" style="opacity: 1;">
                <span class="brand-text font-weight-light">Monitoring Content</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{URL::asset('assets/img/profile/' . Session::get('user_image'))}}" class="img-circle elevation-2" alt="User Image" style="height: 2.1rem;">
                    </div>
                    <div class="info">
                        <a href="{{route('profile', 'me')}}" class="d-block">{{Str::words(Session::get('user_name'), 3)}}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{route('notification')}}" class="nav-link @if(Request::segment(1) == 'notification' || Request::segment(2) == 'notification') {{'active'}} @endif">
                                <i class="nav-icon far fa-bell"></i>
                                <p>
                                    Notification
                                    @if( $unread != 0)
                                    <span class="badge badge-info right">
                                        @if($unread > 99)
                                        99+
                                        @else
                                        {{$unread}}
                                        @endif
                                    </span>
                                    @endif
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">MENU</li>
                        <li class="nav-item">
                            <a href="{{route('home')}}" class="nav-link @if(Request::segment(1) == 'home') {{'active'}} @endif">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('content')}}" class="nav-link @if(Request::segment(1) == 'content' || Request::segment(2) == 'content') {{'active'}} @endif">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Content
                                </p>
                            </a>
                        </li>

                        @php
                        $role = App\Models\User::where('user_id', Session::get('user_id'))->first()->user_role;
                        @endphp

                        @if($role == 'operator')
                        <li class="nav-item">
                            <a href="{{route('content_plus')}}" class="nav-link @if(Request::segment(1) == 'contentplus' || Request::segment(2) == 'contentplus') {{'active'}} @endif">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Content+
                                </p>
                            </a>
                        </li>

                        @elseif( $role == 'admin')
                        <li class="nav-item">
                            <a href="{{route('operator')}}" class="nav-link @if(Request::segment(1) == 'operator' || Request::segment(2) == 'operator') {{'active'}} @endif">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Operator
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('setting')}}" class="nav-link @if(Request::segment(1) == 'setting' || Request::segment(2) == 'setting') {{'active'}} @endif">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>
                                    Setting
                                </p>
                            </a>
                        </li>
                        @endif

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('page')

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block" style="margin-top: -13px;">
                <b>Copyright &copy; {{date('Y')}} Monitoring Content</b> All rights reserved.
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
    <!-- <script src="{{URL::asset('assets/js/jquery/jquery.min.js')}}"></script> -->
    <script src="{{URL::asset('assets/js/jquery/jquery-3.3.1.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{URL::asset('assets/js/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{URL::asset('assets/js/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

    <script src="{{URL::asset('assets/js/sweetalert2/sweetalert2.all.min.js')}}"></script>

    @stack('plugin')

    <!-- AdminLTE App -->
    <script src="{{URL::asset('assets/js/adminlte.min.js')}}"></script>
    <!-- Sweet Alert -->
    <!-- Own Script -->
    <script src="{{URL::asset('assets/js/ScriptSweetalert2.js')}}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{URL::asset('assets/js/demo.js')}}"></script>
    <!-- Page specific script -->

</body>

</html>
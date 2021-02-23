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
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::asset('assets/css/adminlte.css')}}">

</head>

<body class="hold-transition login-page">

  @yield('auth_page')

  <!-- jQuery -->
  <script src="{{URL::asset('assets/js/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{URL::asset('assets/js/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{URL::asset('assets/js/adminlte.min.js')}}"></script>
  <!-- Sweet Alert -->
  <script src="{{URL::asset('assets/js/sweetalert2/sweetalert2.all.min.js')}}"></script>

  <!-- Own Script -->
  <script src="{{URL::asset('assets/js/ScriptSweetalert2.js')}}"></script>
  <script src="{{URL::asset('assets/js/ScriptCheckValidEmail.js')}}"></script>

</body>

</html>
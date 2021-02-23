@extends('layout.auth_main')

@section('title', 'Forgot Password')

@section('auth_page')

@include('layout.flash_alert')

<div class=" login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="{{url('/')}}" class="h1"><img src="{{URL::asset('assets/img/logo/' . $logo)}}" alt="" style="width: 100px;"></a>
            <!-- <h3>Monitoring</h3> -->
        </div>
        <div class="card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            <form action="{{route('forgot_password_process')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="row ">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Forgot Password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <p class="mt-3 mb-1 text-center">
                <a href="{{route('login')}}">Back To Login</a>
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->
@endsection
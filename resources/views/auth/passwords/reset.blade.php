@extends('layout.auth')

@section('title', 'Reset mật khẩu')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Admin</b>VNH</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Please enter your email and new pasword to reset.</p>
            @include('auth.alert')
            <form action="{{ action('Auth\PasswordController@postReset') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required="">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="" required="">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirm" value="" required="">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

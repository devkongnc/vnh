@extends('layout.auth')

@section('title', 'Quên mật khẩu')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Admin</b>VNH</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Please enter your email address. You'll receive a link to create a new password via email.</p>
            @include('auth.alert')
            <form action="{{ action('Auth\PasswordController@postEmail') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Get New Password</button>
                    </div>
                </div>
            </form>
            <a href="{{ action('Auth\AuthController@getLogin') }}">Back</a><br>
            <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
        </div>
    </div>
@endsection

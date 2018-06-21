@extends('layout.auth')

@section('title', 'Đăng nhập')

@section('content')
	<div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Admin</b>VNH</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @include('auth.alert')
            <form action="{{ action('Auth\AuthController@postLogin') }}" method="post">
            	{{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required="">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="" required="">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"{{ old('remember') ? ' checked="checked"' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            </form>
            <!-- <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
            </div> -->
            <a href="{{ action('Auth\PasswordController@getEmail') }}">Forgot your password</a><br>
            <!-- <a href="register.html" class="text-center">Register a new membership</a> -->
        </div>
    </div>
@endsection

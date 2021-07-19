@extends('layouts.guest')
@section('title')ثبت نام | کنترل پنل@stop
@section('content')
<div class="register-box">
    <div class="register-logo">
        <a><b>ثبت نام در سایت</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">ثبت نام کاربر جدید</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group has-feedback @error('name') has-error @enderror">
                <input type="text" class="form-control" placeholder="نام و نام خانوادگی" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input type="email" class="form-control" placeholder="ایمیل" name="email" value="{{ old('email') }}" required autocomplete="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" class="form-control" placeholder="رمز عبور" name="password" required autocomplete="new-password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" class="form-control" placeholder="تکرار رمز عبور" name="password_confirmation" required autocomplete="new-password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" required> من <a href="#">قوانین و شرایط</a> را قبول میکنم.
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">ثبت نام</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{route('login')}}" class="text-center">من قبلا ثبت نام کرده ام</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
@stop

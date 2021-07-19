@extends('layouts.guest')
@section('title')بازنشانی رمز عبور | کنترل پنل@stop
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a><b>بازنشانی رمز عبور</b></a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">بازنشانی رمز عبور</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <input type="email" class="form-control" placeholder="ایمیل" name="email" value="{{ old('email') }}" required autocomplete="email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" placeholder="رمز عبور" name="password" required autocomplete="new-password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" placeholder="تکرار رمز عبور" name="password_confirmation" required autocomplete="new-password">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">بازنشانی رمز</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p>
                <a href="{{route('login')}}" class="text-center">من قبلا ثبت نام کرده ام</a>

            </p>
            <p>
                <a href="{{route('register')}}" class="text-center">ثبت نام کاربر جدید</a>

            </p>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.register-box -->
@stop

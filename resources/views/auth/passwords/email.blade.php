@extends('layouts.guest')
@section('title')فراموشی رمز عبور | کنترل پنل@stop
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a><b>فراموشی رمز عبور</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">ایمیلی که با آن ثبت نام کرده اید را وارد نمایید</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <input type="email" class="form-control" placeholder="ایمیل" name="email" value="{{ old('email') }}"
                           required autocomplete="email" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">ارسال لینک بازنشانی</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{route('register')}}" class="text-center">ثبت نام</a>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@stop

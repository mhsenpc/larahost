@extends('layouts.guest')
@section('title'){{__('message.login-title')}}@stop
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a><b>{{ __('message.login-content-loginbox-titlelink')}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ __('message.login-content-loginbox-message')}}</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <input type="email" class="form-control" placeholder="{{ __('message.login-content-loginbox-form-emailinput-placeholder')}}" name="email" value="{{ old('email') }}"
                           required autocomplete="email" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('message.login-content-loginbox-form-passwordinput-placeholder')}}" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} > {{ __('message.login-content-loginbox-form-remember input-placeholder')}}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('message.login-content-loginbox-form-submitbutton')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{ route('password.request') }}">{{ __('message.login-content-passwordrequest-link')}}</a><br>
            <a href="{{route('register')}}" class="text-center">{{ __('message.login-content-register-requestlink')}}</a>
            <a href="{{ route('demo-login') }}" class="demo-link btn btn-default text-center">{{ __('message.login-content-demoaccount-button')}}</a>  <br>
            <span class="dropdown lang-login">
                @php
                    $locale = App::currentLocale();
                @endphp
                <a class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    @switch($locale)
                        @case('fa')
                        فارسی
                        @break
                        @case('en')
                        english
                        @break
                    @endswitch
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('lang','fa')}}">فارسی</a></li>
                    <li><a class="dropdown-item" href="{{route('lang','en')}}">English</a></li>
                </ul>
            </span>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@stop

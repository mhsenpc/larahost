@extends('layouts.guest')
@section('title'){{ __('message.reset-title')}}@stop
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a><b>{{ __('message.reset-content-registerbox-titlelink')}}</b></a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ __('message.reset-content-registerbox-message')}}</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <input type="email" class="form-control" placeholder="{{ __('message.reset-content-registerbox-form-emailinput-placeholder')}}" name="email" value="{{ old('email') }}" required autocomplete="email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" placeholder="{{ __('message.reset-content-registerbox-form-passwordinput-placeholder')}}" name="password" required autocomplete="new-password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback @error('password') has-error @enderror">
                    <input type="password" class="form-control" placeholder="{{ __('message.reset-content-registerbox-form-confirmpasswordinput-placeholder')}}" name="password_confirmation" required autocomplete="new-password">
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
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('message.reset-content-registerbox-form-submitbutton')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p>
                <a href="{{route('login')}}" class="text-center">{{ __('message.reset-content-registerbox-loginlink')}}</a>

            </p>
            <p>
                <a href="{{route('register')}}" class="text-center">{{ __('message.reset-content-registerbox-registerlink')}}</a>

            </p>
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
                            <li><a class="dropdown-item" href="{{route('lang','fa')}}">English</a></li>
                        </ul>

            </span>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.register-box -->
@stop

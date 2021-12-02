@extends('layouts.guest')
@section('title'){{ __('message.register-title')}}@stop
@section('content')
<div class="register-box">
    <div class="register-logo">
        <a><b>{{ __('message.register-content-registerbox-titlelink')}}</b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">{{ __('message.register-content-registerbox-message')}}</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group has-feedback @error('name') has-error @enderror">
                <input type="text" class="form-control" placeholder="{{ __('message.register-content-registerbox-form-nameinput-placeholder')}}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input type="email" class="form-control" placeholder="{{ __('message.register-content-registerbox-form-emailinput-placeholder')}}" name="email" value="{{ old('email') }}" required autocomplete="email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" class="form-control" placeholder="{{ __('message.register-content-registerbox-form-passwordinput-placeholder')}}" name="password" required autocomplete="new-password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" class="form-control" placeholder="{{ __('message.register-content-registerbox-form-confirmpasswordinput-placeholder')}}" name="password_confirmation" required autocomplete="new-password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" required> {{ __('message.register-content-registerbox-form-terms&conditioncheckbox-agree')}} <a href="#">{{ __('message.register-content-registerbox-form-terms&conditioncheckbox-link')}}</a> {{ __('message.register-content-registerbox-form-terms&conditioncheckbox-accept')}}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('message.register-content-registerbox-form-submitbutton')}}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{route('login')}}" class="text-center">{{ __('message.register-content-registerbox-loginlink')}}</a>
        <span class="dropdown lang-login">
                        @php $locale = session()->get('locale'); @endphp
                        <a class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
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
    <!-- /.form-box -->
</div>
<!-- /.register-box -->
@stop

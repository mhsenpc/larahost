@extends('layouts.guest')
@section('title'){{ __('message.email-title')}}@stop
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a><b>{{ __('message.email-content-loginbox-titlelink')}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ __('message.email-content-loginbox-message')}}</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group has-feedback @error('email') has-error @enderror">
                    <input type="email" class="form-control" placeholder="{{ __('message.email-content-loginbox-form-emailinput-placeholder')}}" name="email" value="{{ old('email') }}"
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
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('message.email-content-loginbox-form-submitbutton')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{route('register')}}" class="text-center">{{ __('message.email-content-loginbox-registerlink')}}</a>
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
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@stop

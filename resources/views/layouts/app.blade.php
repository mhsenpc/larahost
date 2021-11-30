<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>
        @if(isset( $site) && \App\Services\ProgressService::isActive("deploy_{$site->name}"))
            Deploying {{$site->name}}
        @else
            {{$title??''}} | {{ __('message.app-control-panel')}}
        @endif
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!-- jQuery 3 -->
    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

    @include('layouts.partials.css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />


    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: 'ap2'
        });

        window.channel = pusher.subscribe('user-{{\Illuminate\Support\Facades\Auth::id()}}');
    </script>
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue layout-boxed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{{ __('message.app-logo-mini')}}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ __('message.app-logo-lg')}}</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    
                    <li class="dropdown">
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
                            <li><a class="dropdown-item" href="lang/fa">فارسی</a></li>
                            <li><a class="dropdown-item" href="lang/en">English</a></li>
                        </ul>

                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">2</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">2 {{ __('message.app-new-notification')}}</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#"> <i class="fa fa-info"></i> {{ __('message.app-free-service-notification')}} </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-info"></i> {{ __('message.app-welcome-notification')}} </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">{{ __('message.app-all-notif')}}</a></li>
                        </ul>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('dist/img/avatar.png')}}" class="user-image" alt="User Image" />
                            <span class="hidden-xs">{{auth()->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{asset('dist/img/avatar.png')}}" class="img-circle" alt="User Image" />

                                <p>
                                    {{auth()->user()->name}}
                                    <small>{{ __('message.app-user-status-title')}}</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">{{ __('message.app-profile')}}</a>
                                </div>
                                <div class="pull-left">
                                    <a href="{{route('logout')}}" class="btn btn-default btn-flat">{{ __('message.app-exit')}}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- right side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            @if(isset( $sidebar))
                @include($sidebar)
            @else
                @include('layouts.sidebars.main_sidebar')
            @endif
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title??''}}
                <small>{{$description?? ''}}</small>
            </h1>
            <ol class="breadcrumb">
               @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @include('layouts.partials.errors')

            @yield('content')
            @isset($site)
                @include('layouts.partials.action_button')
            @endisset
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer text-left">
        <strong>{{ __('message.app-reserved-right-text')}}</strong>
    </footer>
</div>
<!-- ./wrapper -->
@include('layouts.partials.js')
</body>
</html>

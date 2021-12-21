@extends('layouts.single_box')
@php($title=__('message.dashboard-title'))
@section('box_content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>        
        {{ __('message.dashboard-welcome-text')}}
    </p>

    @isset($isAdmin)
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$sitesCount}}</h3>

                    <p>{{ __('message.dashboard-sitescount-title')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('admin.sites.index')}}" class="small-box-footer">{{ __('message.dashboard-moreinfo')}} <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$usersCount}}</h3>

                    <p>{{ __('message.dashboard-userscount-title')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.users.index')}}" class="small-box-footer">{{ __('message.dashboard-moreinfo')}} <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$domainsCount}}</h3>

                    <p>{{ __('message.dashboard-domainscount-title')}}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{route('admin.domains.index')}}" class="small-box-footer">{{ __('message.dashboard-moreinfo')}} <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
    </div>
    @endisset
@endsection

@section('breadcrumb')
    <li class="active">
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.dashboard-desktop')}}</a>
    </li>
@endsection

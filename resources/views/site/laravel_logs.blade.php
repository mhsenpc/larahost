@extends('layouts.single_box')
@php($title=__('message.laravel-logs-title') . $site->name)
@php($sidebar="layouts.sidebars.site_sidebar")


@if(empty($logs))
@section('content')
    <div class="alert alert-warning">
        {{ __('message.laravel-logs-content-none')}}
    </div>
@endsection
@else
@section('box_content')
    <table class="table">
        <tr>
            <th style="width: 10px">#</th>
            <th>{{ __('message.laravel-logs-tablebox-filenameth')}}</th>
            <th></th>
        </tr>
        @foreach($logs as $key=> $log)
            <tr>
                <td>{{$key +1 }}.</td>
                <td>{{$log}}</td>
                <td><a class="btn btn-default"
                       href="{{route('logs.show',['site_name'=>$site->name ,'file_name'=>$log])}}">{{ __('message.laravel-logs-tablebox-showlogsbutton')}}</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@endif


@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.laravel-logs-breadcrumb-dashbord-homeaddress')}}</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

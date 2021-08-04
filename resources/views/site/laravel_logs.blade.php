@extends('layouts.single_box')
@php($title="گزارش های سایت | " . $site->name)
@php($sidebar="layouts.sidebars.site_sidebar")


@if(empty($logs))
@section('content')
    <div class="alert alert-warning">
        تا کنون فایل log ای توسط این سایت تولید نشده است
    </div>
@endsection
@else
@section('box_content')
    <table class="table">
        <tr>
            <th style="width: 10px">#</th>
            <th>نام فایل</th>
            <th></th>
        </tr>
        @foreach($logs as $key=> $log)
            <tr>
                <td>{{$key +1 }}.</td>
                <td>{{$log}}</td>
                <td><a class="btn btn-default"
                       href="{{route('logs.show',['site_name'=>$site->name ,'file_name'=>$log])}}">نمایش محتویات Log</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@endif


@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

@extends('layouts.single_box')
@php($title="محتویات گزارش ".$file_name)
@php($sidebar="layouts.sidebars.site_sidebar")

@section('box_content')
    <textarea dir="ltr" class="col-md-12" style="height: 25em" id="log_content">{{$log_content}}</textarea>
@endsection

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

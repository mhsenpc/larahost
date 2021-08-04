@extends('layouts.single_box')
@php($title="گزارش Deployment")
@php($sidebar="layouts.sidebars.site_sidebar")
@php($description=$deployment->created_at)

@section('box_content')
    @include('site.last_deployment_log')
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

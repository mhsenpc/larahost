@extends('layouts.single_box')
@php($title=__('message.env-editor-title'))
@php($sidebar="layouts.sidebars.site_sidebar")

@if(empty($env))
@section('content')
    <div class="alert alert-warning">
        {{ __('message.env-editor-contentbox-none')}}
    </div>
@endsection
@else
@section('box_content')
    <form method="post" action="{{route('sites.handle_env_editor',['site'=>$site])}}">
        @csrf
        <textarea dir="ltr" class="col-md-12" style="height: 25em" name="env">{{$env}}</textarea>
        <div class="clearfix">&nbsp;</div>
        <input type="submit" class="btn btn-primary" value="{{ __('message.env-editor-formbox-submitbutton')}}">
    </form>
@endsection
@endif

@section('breadcrumb')
    <li>
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.env-editor-breadcrumb-dashboard-homeaddress')}}</a>
    </li>

    <li>
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

@extends('layouts.single_box')
@php($title="ویرایش فایل env")
@php($sidebar="layouts.sidebars.site_sidebar")

@if(empty($env))
@section('content')
    <div class="alert alert-warning">
        متاسفانه فایل env پروژه شما پیدا نشد
    </div>
@endsection
@else
@section('box_content')
    <form method="post" action="{{route('sites.handle_env_editor',['site'=>$site])}}">
        <textarea dir="ltr" class="col-md-12" style="height: 25em" name="env">{{$env}}</textarea>
        <div class="clearfix">&nbsp;</div>
        <input type="submit" class="btn btn-primary" value="ذخیره">
    </form>
@endsection
@endif

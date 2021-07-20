@extends('layouts.single_box')
@php($title="گزارش Deployment")
@php($sidebar="layouts.sidebars.site_sidebar")

@section('box_content')
    <textarea dir="ltr" class="col-md-12" style="height: 25em" id="log_content">{{$log_content}}</textarea>
@endsection

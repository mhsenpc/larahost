@extends('layouts.single_box')
@php($title="گزارش Deployment")
@php($sidebar="layouts.site_sidebar")

@section('box_content')
    <textarea style=" width: 600px;height: 400px;" id="log_content">{{$log_content}}</textarea>
@endsection

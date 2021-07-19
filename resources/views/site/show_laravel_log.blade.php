@extends('layouts.single_box')
@php($title="محتویات گزارش ".$file_name)
@php($sidebar="layouts.site_sidebar")

@section('box_content')
    <textarea dir="ltr" class="col-md-12" style="height: 25em" id="log_content">{{$log_content}}</textarea>
@endsection

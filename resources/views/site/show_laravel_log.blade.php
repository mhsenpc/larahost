@extends('layouts.single_box')
@php($title="گزارش های لاراول")
@php($sidebar="layouts.site_sidebar")

@section('box_content')
    <p>
        <label for="log_content">Log content</label>
    </p>
    <p>
        <textarea id="log_content">{{$log_content}}</textarea>
    </p>
@endsection

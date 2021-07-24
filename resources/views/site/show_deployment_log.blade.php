@extends('layouts.single_box')
@php($title="گزارش Deployment | ".$deployment->created_at)
@php($sidebar="layouts.sidebars.site_sidebar")

@section('box_content')
    @include('site.last_deployment_log')
@endsection

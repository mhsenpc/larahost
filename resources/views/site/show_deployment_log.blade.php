@extends('layouts.single_box')
@php($title="گزارش Deployment")
@php($sidebar="layouts.sidebars.site_sidebar")

@section('box_content')
    @include('site.last_deployment_log')
@endsection

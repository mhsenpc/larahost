@extends('layouts.single_box')
@php($title="گزارش های سایت | " . $site->name)
@php($sidebar="layouts.site_sidebar")


@if(empty($logs))
@section('content')
    <div class="alert alert-warning">
        تا کنون فایل log ای توسط این سایت تولید نشده است
    </div>
@endsection
@else
@section('box_content')
    <table class="table">
        <tr>
            <th>File Name</th>
            <th></th>
        </tr>
        @foreach($logs as $log)
            <tr>
                <td>{{$log}}</td>
                <td><a class="btn btn-secondary"
                       href="{{route('logs.show',['project_name'=>$project_name ,'file_name'=>$log])}}">View Log</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@endif


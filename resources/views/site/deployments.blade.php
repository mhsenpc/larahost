@extends('layouts.single_box')
@php($title="تاریخچه Deploy")
@php($sidebar="layouts.sidebars.site_sidebar")

@if(count($deployments) == 0)
@section('content')
    <div class="alert alert-warning">
        تاکنون هیچ deployment ای برای این سایت انجام نشده است
    </div>
@endsection
@else
@section('box_content')
    <table class="table">
        <tr>
            <th style="width: 10px">#</th>
            <th>تاریخ</th>
            <th>وضعیت</th>
            <th></th>
        </tr>

        @foreach($deployments as $key=> $deployment)
            <tr >
                <td>{{$key +1 }}.</td>
                <td>{{$deployment->created_at}}</td>
                <td>
                    @if($deployment->success)
                        <span class="bg-success">موفق</span>
                    @else
                        <span class="bg-warning">ناموفق</span>
                    @endif
                </td>
                <td><a class="btn btn-default"
                       href="{{route('deployments.showLog',['deployment_id'=>$deployment->id])}}">نمایش گزارش deploy</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@endif

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

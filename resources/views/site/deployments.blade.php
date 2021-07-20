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
            <th></th>
        </tr>

        @foreach($deployments as $key=> $deployment)
            <tr {!!  ($deployment->success == false)?'class="failed_deployment"':'' !!}>
                <td>{{$key +1 }}.</td>
                <td>{{$deployment->created_at}}</td>
                <td><a class="btn btn-default"
                       href="{{route('deployments.showLog',['id'=>$deployment->id])}}">نمایش گزارش deploy</a></td>
            </tr>
        @endforeach
    </table>
@endsection
@endif

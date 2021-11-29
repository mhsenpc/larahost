@extends('layouts.single_box')
@php($title="تاریخچه Deploy")
@php($sidebar="layouts.sidebars.site_sidebar")

@if(count($deployments) == 0)
@section('content')
    <div class="alert alert-warning">
        {{ __('message.deployments-historynone-alert')}}
    </div>
@endsection
@else
@section('box_content')
    <table class="table">
        <tr>
            <th style="width: 10px">#</th>
            <th>{{ __('message.deployments-historycontent-table-historyth')}}</th>
            <th>{{ __('message.deployments-historycontent-table-statusth')}}</th>
            <th></th>
        </tr>

        @foreach($deployments as $key=> $deployment)
            <tr >
                <td>{{$key +1 }}.</td>
                <td>{{$deployment->created_at}}</td>
                <td>
                    @if($deployment->success)
                        <span class="bg-success">{{ __('message.deployments-historycontent-table-successfullstatus')}}</span>
                    @else
                        <span class="bg-warning">{{ __('message.deployments-historycontent-table-failedstatus')}}</span>
                    @endif
                </td>
                <td><a class="btn btn-default"
                       href="{{route('deployments.showLog',['deployment_id'=>$deployment->id])}}">{{ __('message.deployments-historycontent-table-report')}}</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@endif

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.deployments-breadcrumb-dashbordhome')}}</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

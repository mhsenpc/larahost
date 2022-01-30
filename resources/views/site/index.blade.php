@extends('layouts.single_box')
@php($title=__('message.index-title'))
@php($description= trans('message.index-description'))
@section('box_content')
    <table class="table table-bordered">
        <tr>
            <th style="width: 10px">#</th>
            <th>{{ __('message.index-tablebox-sitenameth')}}</th>
            <th>{{ __('message.index-tablebox-subdomain-nameth')}}</th>
        </tr>

        @foreach($sites as $key=> $site1)
            <tr>
                <td>{{$key+1}}.</td>
                <td>
                    @if(\App\Services\ProgressService::isActive("create_{$site1->name}"))
                        <a >{{$site1->name}}</a>
                        <i class="fa fa-refresh" title="{{ __('message.index-tablebox-progressiveofservice-title')}}"> </i>
                    @else
                        <a href="{{route('sites.show',$site1)}}">{{$site1->name}}</a>
                    @endif

                </td>
                <td><a target="_blank" href="http://{{$site1->name}}{{config('larahost.sudomain')}}">{{$site1->name}}{{config('larahost.sudomain')}}</a></td>
            </tr>
        @endforeach
    </table>
    {{$sites->links()}}
@endsection

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.index-breadcrumb-dashboard-homeaddress')}}</a>
    </li>

    <li class="active" >
        <a href="{{route('sites.index')}}">{{ __('message.index-breadcrumb-mysites')}}</a>
    </li>
@endsection

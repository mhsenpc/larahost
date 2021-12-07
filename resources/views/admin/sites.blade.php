@extends('layouts.single_box')
@php($title= __('message.admin-site-title'))
@php($description= __('message.admin-site-description'))
@section('box_content')
    <table class="table table-bordered">
        <tr>
            <th style="width: 10px">#</th>
            <th>{{ __('message.admin-site-boxcontent-table-sitenameth')}}</th>
            <th>{{ __('message.admin-site-boxcontent-table-domainscountth')}}</th>
            <th>{{ __('message.admin-site-boxcontent-table-vendorth')}}</th>
            <th></th>
        </tr>

        @foreach($sites as $key=> $site1)
            <tr>
                <td>{{$key+1}}.</td>
                <td>
                    <a href="{{route('sites.show',['site'=>$site1])}}"> {{$site1->name}}</a>
                </td>
                <td>{{$site1->domains->count()}}</td>
                <td><span title="{{$site1->user->email}}">{{$site1->user->name }}</span></td>
            </tr>
        @endforeach
    </table>
    {{$sites->links()}}
@endsection

@section('breadcrumb')
    <li>
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.admin-site-breadcrumb-dashbord-homeaddress')}}</a>
    </li>
    <li>
        <a href="{{route('dashboard')}}"> {{ __('message.admin-site-breadcrumb-management')}}</a>
    </li>

    <li class="active">
        <a href="{{route('admin.sites.index')}}">{{ __('message.admin-site-breadcrumb-siteslist')}}</a>
    </li>
@endsection

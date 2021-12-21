@extends('layouts.single_box')
@php($title= __('message.admin-domains-title'))
@php($description= __('message.admin-domains-description'))
@section('box_content')
    <table class="table table-bordered">
        <tr>
            <th style="width: 10px">#</th>
            <th>{{ __('message.admin-domains-boxcontent-table-domainth')}}</th>
            <th>{{ __('message.admin-domains-boxcontent-table-sitenameth')}}</th>
            <th>{{ __('message.admin-domains-boxcontent-table-vendorth')}}</th>
            <th></th>
        </tr>

        @foreach($domains as $key=> $domain)
            <tr>
                <td>{{$key+1}}.</td>
                <td><a target="_blank" href="http://{{$domain->name}}">{{$domain->name}}</a></td>
                <td><a href="{{route('sites.show',['site'=>$domain->site])}}"> {{$domain->site->name}}</a></td>
                <td><span title="{{$domain->site->user->email}}">{{$domain->site->user->name }}</span></td>
            </tr>
        @endforeach
    </table>
    {{$domains->links()}}
@endsection

@section('breadcrumb')
    <li>
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.admin-domains-breadcrumb-dashboard-homeaddress')}}</a>
    </li>
    <li>
        <a href="{{route('dashboard')}}"> {{ __('message.admin-domains-breadcrumb-management')}}</a>
    </li>

    <li class="active">
        <a href="{{route('admin.domains.index')}}">{{ __('message.admin-domains-breadcrumb-domainslist')}}</a>
    </li>
@endsection

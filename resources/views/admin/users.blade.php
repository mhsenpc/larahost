@extends('layouts.single_box')
@php($title= __('message.admin-users-title'))
@php($description= __('message.admin-users-description'))
@section('box_content')
<table class="table table-bordered">
    <tr>
        <th style="width: 10px">#</th>
        <th>{{ __('message.admin-users-contentbox-table-nameth')}}</th>
        <th>{{ __('message.admin-users-contentbox-table-emailth')}}</th>
        <th>{{ __('message.admin-users-contentbox-table-sitesth')}}</th>
        <th></th>
    </tr>

    @foreach($users as $key=> $user)
    <tr>
        <td>{{$key+1}}.</td>
        <td>{{$user->name}}.</td>
        <td>{{$user->email}}.</td>
        <td>{{$user->sites->count()}}</td>
        <td><a class="btn btn-primary" href="{{route('admin.users.loginAs',['user_id'=>$user->id])}}">{{ __('message.admin-users-contentbox-table-loginastd')}} {{$user->name}}</a> </td>
    </tr>
    @endforeach
</table>
    {{$users->links()}}
@endsection

@section('breadcrumb')
<li >
    <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.admin-users-breadcrumb-dashboard-homeaddress')}}</a>
</li>
<li >
    <a  href="{{route('dashboard')}}"> {{ __('message.admin-users-breadcrumb-management')}}</a>
</li>

<li class="active" >
    <a href="{{route('admin.users.index')}}">{{ __('message.admin-users-breadcrumb-userslist')}}</a>
</li>
@endsection

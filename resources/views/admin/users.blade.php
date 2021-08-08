@extends('layouts.single_box')
@php($title="کاربران سایت")
@php($description="لیست تمامی کاربرانی که ثبت نام کرده اند")
@section('box_content')
<table class="table table-bordered">
    <tr>
        <th style="width: 10px">#</th>
        <th>نام</th>
        <th>ایمیل</th>
        <th>سایت ها</th>
        <th></th>
    </tr>

    @foreach($users as $key=> $user)
    <tr>
        <td>{{$key+1}}.</td>
        <td>{{$user->name}}.</td>
        <td>{{$user->email}}.</td>
        <td>{{$user->sites->count()}}</td>
        <td><a class="btn btn-primary" href="{{route('admin.users.loginAs',['user_id'=>$user->id])}}">ورود {{$user->name}}</a> </td>
    </tr>
    @endforeach
</table>
    {{$users->links()}}
@endsection

@section('breadcrumb')
<li >
    <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
</li>
<li >
    <a  href="{{route('dashboard')}}"> مدیریت</a>
</li>

<li class="active" >
    <a href="{{route('admin.users.index')}}">لیست کاربران</a>
</li>
@endsection

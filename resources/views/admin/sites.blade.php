@extends('layouts.single_box')
@php($title="سایت ها")
@php($description="لیست تمامی سایت ها")
@section('box_content')
    <table class="table table-bordered">
        <tr>
            <th style="width: 10px">#</th>
            <th>نام سایت</th>
            <th>تعداد دامنه ها</th>
            <th>مالک</th>
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
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
    </li>
    <li>
        <a href="{{route('dashboard')}}"> مدیریت</a>
    </li>

    <li class="active">
        <a href="{{route('admin.sites.index')}}">لیست سایت ها</a>
    </li>
@endsection

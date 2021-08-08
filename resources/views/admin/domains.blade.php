@extends('layouts.single_box')
@php($title="دامنه ها")
@php($description="لیست دامنه ها")
@section('box_content')
    <table class="table table-bordered">
        <tr>
            <th style="width: 10px">#</th>
            <th>دامنه</th>
            <th>نام سایت</th>
            <th>مالک</th>
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
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
    </li>
    <li>
        <a href="{{route('dashboard')}}"> مدیریت</a>
    </li>

    <li class="active">
        <a href="{{route('admin.domains.index')}}">لیست دامنه ها</a>
    </li>
@endsection

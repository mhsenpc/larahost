@extends('layouts.single_box')
@php($title="سایت های من")
@php($description="لیست سایت هایی که تاکنون ساخته اید")
@section('box_content')
    <table class="table table-bordered">
        <tr>
            <th style="width: 10px">#</th>
            <th>نام سایت</th>
            <th>زیر دامنه (رایگان)</th>
        </tr>

        @foreach($sites as $key=> $site1)
            <tr>
                <td>{{$key+1}}.</td>
                <td>
                    @if(\App\Services\ProgressService::isActive("create_{$site1->name}"))
                        <a >{{$site1->name}}</a>
                        <i class="fa fa-refresh" title="در حال نصب و راه اندازی"> </i>
                    @else
                        <a href="{{route('sites.show',$site1)}}">{{$site1->name}}</a>
                    @endif

                </td>
                <td><a target="_blank" href="http://{{$site1->name}}.lara-host.ir">{{$site1->name}}.lara-host.ir</a></td>
            </tr>
        @endforeach
    </table>
    {{$sites->links()}}
@endsection

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
    </li>

    <li class="active" >
        <a href="{{route('sites.index')}}">سایت های من</a>
    </li>
@endsection

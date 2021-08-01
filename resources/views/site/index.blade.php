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
                    <a href="{{route('sites.show',$site1)}}">{{$site1->name}}</a>
                    @if(\App\Services\ProgressService::isActive("create_{$site1->name}"))
                        <i class="fa fa-refresh" title="در حال نصب و راه اندازی"> </i>
                    @endif
                </td>
                <td><a target="_blank" href="http://{{$site1->name}}.gnulover.ir">{{$site1->name}}.gnulover.ir</a></td>
            </tr>
        @endforeach
    </table>
@endsection

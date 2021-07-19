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

        @foreach($sites as $key=> $site)
            <tr>
                <td>{{$key+1}}.</td>
                <td><a href="{{route('sites.show',$site)}}">{{$site->name}}</a></td>
                <td><a target="_blank" href="http://{{$site->name}}.gnulover.ir">{{$site->name}}.gnulover.ir</a></td>
            </tr>
        @endforeach
    </table>
@endsection

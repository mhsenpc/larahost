@extends('layouts.single_box')
@php($title="سایت های من")
@php($description="لیست سایت هایی که تاکنون ساخته اید")
@section('content')
    <a class="btn btn-success" href="{{route('sites.create')}}">Add Site</a>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Sub Domain</th>
        </tr>

        @foreach($sites as $site)
            <tr>
                <td><a href="{{route('sites.show',$site)}}">{{$site->name}}</a></td>
                <td><a target="_blank" href="http://{{$site->name}}.gnulover.ir">{{$site->name}}.gnulover.ir</a></td>
            </tr>
        @endforeach
    </table>
@endsection

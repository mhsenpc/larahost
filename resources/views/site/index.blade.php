@extends('layouts.app')

@section('content')
    <a class="btn btn-success" href="{{route('sites.create')}}">Add Site</a>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Domain</th>
        </tr>

        @foreach($sites as $site)
            <tr>
                <td>{{$site->name}}</td>
                <td>{{$site->domain}}</td>
            </tr>
        @endforeach
    </table>
@endsection

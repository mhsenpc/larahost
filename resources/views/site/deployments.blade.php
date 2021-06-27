@extends('layouts.app')

@section('content')
    <table class="table">
        <tr>
            <th>Date</th>
            <th>Log</th>
        </tr>

        @foreach($deployments as $deployment)
            <tr>
                <td>{{$deployment->created_at}}</td>
                <td><a class="btn btn-secondary" target="_blank" href="{{route('deployments.showLog',['id'=>$deployment->id])}}">View deployment Log</a></td>
            </tr>
        @endforeach
    </table>
@endsection

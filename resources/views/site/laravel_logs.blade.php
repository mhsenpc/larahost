@extends('layouts.app')

@section('content')
    @if(empty($logs))
        <div class="alert alert-warning">
            No log files generated yet
        </div>
    @else
        <table class="table">
            <tr>
                <th>File Name</th>
                <th></th>
            </tr>
            @foreach($logs as $log)
                <tr>
                    <td>{{$log}}</td>
                    <td><a class="btn btn-secondary"
                           href="{{route('logs.show',['project_name'=>$project_name ,'file_name'=>$log])}}">View Log</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection

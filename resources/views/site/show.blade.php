@extends('layouts.app')

@section('content')
    <h2>{{$site->name}}</h2>
    <p>current server status:
        @if($running)
            <span>Active</span>
        @else
            <span>Power Off</span>
        @endif
    </p>

    <p>
        @if($running)
            <a class="btn btn-warning" href="{{route('sites.stop',['name'=>$site->name])}}">Stop Site</a>
        @else
            <a class="btn btn-success" href="{{route('sites.start',['name'=>$site->name])}}">Start Site</a>
        @endif

        <a class="btn btn-secondary" href="{{route('sites.restart',['name'=>$site->name])}}">Restart Site</a>
    </p>

    <p>
        <a class="btn btn-danger" href="">Remove Site</a>
    </p>
@stop

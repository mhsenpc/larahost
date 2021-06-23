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
            <a class="btn btn-warning" href="{{route('site.stop',['name'=>$site->name])}}">Stop Site</a>
        @else
            <a class="btn btn-success" href="{{route('site.start',['name'=>$site->name])}}">Start Site</a>
        @endif

        <a class="btn btn-secondary" href="{{route('site.restart',['name'=>$site->name])}}">Restart Site</a>
    </p>

    <form method="post" action="{{route('sites.remove',['id'=> $site->id])}}"  >
        @csrf
        <input type="submit" class="btn btn-danger" value="Remove Site" onclick="return confirm('Are you sure? This action is irreversible')"/>
    </form>
@stop
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
            <a class="btn btn-warning" href="{{route('site.stop',['site'=>$site])}}">Stop Site</a>
        @else
            <a class="btn btn-success" href="{{route('site.start',['site'=>$site])}}">Start Site</a>
        @endif

        <a class="btn btn-secondary" href="{{route('site.restart',['site'=>$site])}}">Restart Site</a>
    </p>

    <p>
        <a class="btn btn-dark" href="{{route('site.redeploy',['site'=>$site])}}">Redeploy Site</a>
    </p>

    <form method="post" action="{{route('sites.remove',['site'=> $site])}}">
        @csrf
        <input type="submit" class="btn btn-danger" value="Remove Site"
               onclick="return confirm('Are you sure? This action is irreversible')"/>
    </form>

    <p>
        <a href="{{route('sites.deployments',['site'=>$site])}}">Deployments</a>
    </p>

    <p>
        <a href="{{route('sites.logs',['site'=>$site])}}">Laravel Logs</a>
    </p>

    <p>
        <a href="{{route('sites.deploy_commands',['site'=> $site])}}">Deploy Commands</a>
    </p>
@stop

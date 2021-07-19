@extends('layouts.single_box')
@php($title="وضعیت سایت ".$site->name)
@php($sidebar="layouts.site_sidebar")

@section('box_content')
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
            <a class="btn btn-warning" href="{{route('sites.stop',['site'=>$site])}}">Stop Site</a>
        @else
            <a class="btn btn-success" href="{{route('sites.start',['site'=>$site])}}">Start Site</a>
        @endif

        <a class="btn btn-secondary" href="{{route('sites.restart',['site'=>$site])}}">Restart Site</a>
    </p>

    <p>
        <a class="btn btn-dark" href="{{route('sites.redeploy',['site'=>$site])}}">Redeploy Site</a>
    </p>
@stop

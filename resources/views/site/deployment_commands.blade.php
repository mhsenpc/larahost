@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">

        <form method="post" action="{{route('sites.save_deploy_commands',['site'=>$site])}}">
            @csrf
            <p>
                <textarea style=" width: 600px;height: 400px;" name="deploy_commands">{{$site->deploy_commands}}</textarea>
            </p>
            <p>
                <input type="submit" class="btn btn-primary" value="save">
            </p>
        </form>
    </div>
@endsection

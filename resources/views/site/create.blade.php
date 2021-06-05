@extends('layouts.app')

@section('content')
    <form action="{{route('sites.store')}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-2">
                <label for="name">name</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="name" id="name">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2">
                <label for="repo">repo</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="repo" id="repo">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2">
                <label for="domain">domain</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="domain" id="domain" placeholder="e.g: amazon.com">
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-2">
                <input type="submit" value="create" class="btn btn-primary"/>
            </div>

        </div>
    </form>
@stop

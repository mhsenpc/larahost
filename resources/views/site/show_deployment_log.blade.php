@extends('layouts.single_box')
@php($title="گزارش Deployment")

@section('content')
    <div class="row justify-content-center">

    <p>
        <textarea  style=" width: 600px;height: 400px;" id="log_content">{{$log_content}}</textarea>
    </p>


    </div>
@endsection

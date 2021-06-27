@extends('layouts.app')

@section('content')
    <p>
        <label for="log_content">Log content</label>
    </p>
    <p>
        <textarea id="log_content">{{$log_content}}</textarea>
    </p>
@endsection

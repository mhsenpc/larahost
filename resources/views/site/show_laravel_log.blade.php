@extends('layouts.single_box')
@php($title="گزارش لاراول")

@section('content')
    <p>
        <label for="log_content">Log content</label>
    </p>
    <p>
        <textarea id="log_content">{{$log_content}}</textarea>
    </p>
@endsection

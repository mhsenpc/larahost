@extends('layouts.single_box')
@php($title="داشبورد")

@section('box_content')
    <div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        به لاراهاست خوش آمدید
    </div>
@endsection

@section('breadcrumb')
    <li class="active">
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> میزکار</a>
    </li>
@endsection

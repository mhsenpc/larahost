@extends('layouts.single_box')
@php($title="دستورات Deploy")
@php($sidebar="layouts.site_sidebar")

@section('box_content')
    <p>
        با قابلیتی که در این بخش قرار داده ایم، شما می توانید دستوراتی که بعد از هر deploy در سرور اجرا می شوند را تعیین نمایید
    </p>
    <form method="post" action="{{route('sites.save_deploy_commands',['site'=>$site])}}">
        @csrf
        <p>
            <textarea dir="ltr" class="col-md-12" style="height: 15em" name="deploy_commands">{{$site->deploy_commands}}</textarea>
        </p>
        <p></p>
        <p>
            <input type="submit" class="btn btn-primary" value="ذخیره">
        </p>
    </form>
@endsection

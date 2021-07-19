@extends('layouts.single_box')
@php($title="حذف سایت ".$site->name)
@php($sidebar="layouts.site_sidebar")

@section('box_content')
    <p>
        با حذف کردن سایت، تمامی اطلاعات شامل فایل ها، اسکریپت ها، اطلاعات موجود در بانک اطلاعاتی و تمامی نسخه های پشتیبان حذف می شوند.
    </p>
    <form method="post" action="{{route('sites.remove',['site'=> $site])}}">
        @csrf
        <input type="submit" class="btn btn-danger" value="حذف سایت"
               onclick="return confirm('آیا از حذف سایت {{$site->name}} اطمینان دارید؟ این عملیات غیرقابل بازگشت است!' )"/>
    </form>
@endsection

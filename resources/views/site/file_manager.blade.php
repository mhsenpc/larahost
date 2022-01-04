@extends('layouts.single_box')
@php($title=__('message.file-manager'))
@php($sidebar="layouts.sidebars.site_sidebar")

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


</head>
<body>

@section('breadcrumb')
    <iframe src="{{ url('sites.file_manager') }}"></iframe>
@endsection

</body>
</html>

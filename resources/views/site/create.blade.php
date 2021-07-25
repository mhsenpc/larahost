@extends('layouts.single_box')
@php($title="ایجاد سایت جدید")
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">راه اندازی سایت</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{route('sites.store')}}" method="post">
            <div class="box-body">
                @csrf
                <div class="form-group">
                    <label for="name">نام سایت</label>
                    <input type="text" name="name" id="name" class="form-control dir-ltr" required placeholder="my_beautiful_gallery" value="{{$faker->domainName}}" >
                </div>

                <div class="form-group">
                    <label for="repo">آدرس repository</label>
                    <input type="text" name="repo" id="repo" value="https://github.com/laravel/laravel"
                           class="form-control dir-ltr" required placeholder="https://github.com/laravel/laravel">
                </div>

                @if(!empty($public_key))
                    <div class="row">
                        <div class="callout callout-warning">
                            <h4>توجه </h4>

                            <p> برای deploy موفق، نیاز به افزودن این کلید به Git Server خود دارید </p>
                            <p class="text-left dir-ltr" style="word-break: break-all;">
                                {{$public_key}}
                            </p>
                        </div>
                    </div>
                @endif

                <div class="box-footer">
                    <input type="submit" value="راه اندازی سایت" class="btn btn-primary"/>
                </div>
            </div>
        </form>
    </div>
    <!-- /.box -->

    <script>
        $(document).ready(function () {
            $('#name').keyup(function (e) {
                var clean_name = this.value.replace(/[^A-Za-z0-9\.\_\-]/g, "");
                $('#name').val(clean_name);
            });
        });
    </script>
@stop

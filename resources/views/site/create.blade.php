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
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="repo">آدرس repository</label>
                    <input type="text" name="repo" id="repo" value="https://github.com/laravel/laravel" class="form-control" required>
                </div>

                @if(!empty($public_key))
                <div class="form-group">
                    <div class="alert alert-warning">
                        توجه کنید که برای deploy موفق، نیاز به افزودن این کلید به Git Server خود هستید
                        <br/>
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
                var clean_name = this.value.replace(/[^A-Za-z0-9]/g, "");
                $('#name').val(clean_name);
            });
        });
    </script>
@stop

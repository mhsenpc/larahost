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

                <!-- checkbox -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="manual_credentials" id="manual_credentials" value="1">
                        Manual
                        Credentials
                    </label>

                </div>

                <div id="manual_credentials_area" class="lara_hidden">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <label for="username">Username</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="username" id="username" value="">
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="password" id="password" value="">
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <input type="submit" value="راه اندازی سایت" class="btn btn-primary"/>
                </div>
            </div>
        </form>
    </div>
    <!-- /.box -->

    <script>
        $(document).ready(function () {
            $('#manual_credentials').on('ifChanged', function () {
                console.log(this.checked);
                if (this.checked) {
                    $("#manual_credentials_area").show();
                } else {
                    $("#manual_credentials_area").hide();
                }
            });

            $('#name').keyup(function (e) {
                var clean_name = this.value.replace(/[^A-Za-z0-9]/g, "");
                $('#name').val(clean_name);
            });
        });
    </script>
@stop

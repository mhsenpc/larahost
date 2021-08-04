@extends('layouts.single_box')
@php($title="ایجاد سایت جدید")
@section('content')
    @if($sites_count)
        <div class="alert alert-warning">
            ضمن تشکر از علاقه مندی شما به سرویس لاراهاست، لازم به ذکر هست که در حال حاضر هر کاربر مجاز به ساخت فقط یک
            سایت می باشد. یقینا پس از اتمام دوره آزمایشی و اعمال هزینه بر روی سرویس، میزبان سایت های شما به تعداد
            نامحدود خواهیم بود
        </div>
    @endif

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
                    <input type="text" name="name" id="name" class="form-control dir-ltr" required
                           placeholder="my_beautiful_gallery" value="{{$faker->domainWord }}">
                </div>

                <div class="form-group">
                    <label for="repo">آدرس Repository</label>
                    <input type="text" name="repo" id="repo" value="https://github.com/laravel/laravel"
                           class="form-control dir-ltr" required placeholder="https://github.com/laravel/laravel">
                </div>

                <!-- checkbox -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="manual_credentials" id="manual_credentials" value="1">
                        این Repository اختصاصی است و نیاز به احراز هویت دارد
                    </label>

                </div>

                <div class="nav-tabs-custom lara_hidden" id="private_repository">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ssh_key" data-toggle="tab">احراز هویت با کلید</a></li>
                        <li><a href="#basic_auth" data-toggle="tab">احراز هویت سنتی</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="active tab-pane" id="ssh_key">
                            <div class="row">
                                <div class="callout callout-info">
                                    <h4>توجه </h4>

                                    <p> این کلید را در Git Server مربوطه در بخش کلید ها اضافه نمایید </p>
                                    <p class="text-left dir-ltr" style="word-break: break-all;">
                                        {{$public_key}}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="basic_auth">
                            <div class="row">
                                <div class="callout callout-warning">
                                    <h4>توجه </h4>

                                    <p>لطفا جهت بالابردن ضریب امنیت خودتان، تا حد امکان از این نوع احراز هویت
                                        استفاده نفرمایید بلکه از احراز هویت با کلید استفاده کنید.</p>
                                    <p class="text-left dir-ltr" style="word-break: break-all;">
                                        {{$public_key}}
                                    </p>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <label for="username">نام کاربری Git</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="username" id="username" value="">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <label for="password">رمز عبور Git</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" type="password" name="password" id="password"
                                           value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="box-footer">
                    <input type="submit" value="راه اندازی سایت" class="btn btn-primary"
                           @if($sites_count) disabled @endif/>
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
                    $("#private_repository").show();
                } else {
                    $("#private_repository").hide();
                }
            });

            $('#name').keyup(function (e) {
                var clean_name = this.value.replace(/[^A-Za-z0-9]/g, "");
                $('#name').val(clean_name);
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
    </li>

    <li >
        <a href="{{route('sites.index')}}"> سایت های من</a>
    </li>

    <li class="active">
        <a > ایجاد سایت جدید</a>
    </li>
@endsection

@extends('layouts.single_box')
@php($title="میزکار سایت ".$site->name)
@php($sidebar="layouts.sidebars.site_sidebar")

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Deployment
            </div>
            <div class="box-tools pull-left">
                <a href="{{route('sites.redeploy',['site'=>$site])}}" type="button" class="btn btn-success @if(!$running) disabled @endif">Deploy
                    Now</a>
            </div>
        </div>
        <div class="box-body">
            <div class="alert alert-info">
                اگر انتظار دارید که به محض push کردن در نرم افزار کنترل نسخه، عملیات deploy شروع شود، لازم است که تریگر
                مربوطه که در بخش Deployment Trigger URL وجود دارد را تنظیم نمایید
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button id="show_deployment_modal" class="btn btn-default" data-toggle="modal"
                    data-target="#modal-last-deployment">دیدن گزارش آخرین Deployment
            </button>
        </div>
    </div>

    <div class="box">
        <form method="post" action="{{route('sites.save_deploy_commands',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    Deploy Script
                    <small class="text-muted">
                        در این بخش می توانید دستوراتی که بعد از هر deploy لازم است در سرور اجرا
                        شوند را تعیین نمایید
                    </small>
                </div>
            </div>
            <div class="box-body">
                <textarea dir="ltr" class="col-md-12" style="height: 15em"
                          name="deploy_commands">{{$site->deploy_commands}}</textarea>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-success">ذخیره</button>
            </div>
        </form>
    </div>


    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Deployment Trigger URL
            </div>
        </div>
        <div class="box-body">
            در صورتی که بخواهید به محض push کردن کدها در نرم افزار سورس کنترل و یا پس از اتمام عملیات تست اتوماتیک توسط
            نرم افزارهایی همانند Jenkins یا CircleCI، لاراهاست کدهای شما را از سیستم کنترل نسخه دریافت کرده و بطور
            اتوماتیک روی سایت شما بارگذاری کند کافیست یک درخواست Get و یا Post به آدرس زیر داده شود که این امر باعث شروع
            عملیات Deploy خودکار می شود
            <div class="alert alert-warning text-left">
                <a href="{{route('triggerDeployment',['token'=> $site->deploy_token])}}">{{route('triggerDeployment',['token'=> $site->deploy_token])}}</a>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a class="btn btn-success" href="{{route('sites.regenerate_deploy_token',['site'=>$site])}}">تغییر Token</a>
        </div>
    </div>

    @if($maintenace_status)
        <div class="box">
            <form method="post" action="{{route('sites.maintenance_up',['site'=> $site])}}">
                @csrf
                <div class="box-header with-border">
                    <div class="pull-right">
                        حالت تعمیر
                    </div>
                </div>
                <div class="box-body">
                    <div class="alert alert-warning">
                        <p> در حال حاضر سایت شما در حالت تعمیر قرار دارد</p>
                    </div>
                    <p class="text-left text-center"><a target="_blank"
                                                        href="http://{{$site->name}}.gnulover.ir/{{$maintenace_secret}}">http://{{$site->name}}
                            .gnulover.ir/{{$maintenace_secret}}</a></p>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-success"
                    ><span>خروج از حالت تعمیر</span></button>
                </div>
            </form>
        </div>
    @else
        <div class="box">
            <form method="post" action="{{route('sites.maintenance_down',['site'=>$site])}}">
                @csrf
                <div class="box-header with-border">
                    <div class="pull-right">
                        حالت تعمیر
                    </div>
                </div>
                <div class="box-body">
                    <div class="alert alert-info">
                        فعال سازی حالت تعمیر باعث خارج شدن سایت از دسترس عموم می شود
                    </div>
                    <div class="form-group row"><label for="secret" class="col-md-3 col-form-label text-md-right">عبارت
                            مخفی</label>
                        <div class="col-md-8"><input type="text" id="secret" name="secret" class="form-control dir-ltr"> <span
                                class="form-text">نکته: فقط لاراول 8 توانایی استفاده از  <a
                                    href="https://laravel.com/docs/8.x/configuration#bypassing-maintenance-mode"
                                    target="_blank">عبارت مخفی</a> را دارد.</span></div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" href="{{route('sites.maintenance_down',['site'=>$site])}}"
                            class="btn btn-warning"
                    ><span>فعال سازی حالت تعمیر</span></button>
                </div>
            </form>
        </div>
    @endif

    <div class="box">
        <form method="post" action="{{route('sites.update_git_remote',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    تغییر Git Remote
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    در این بخش می توانید Git remote Url متصل به سایت خود را تغییر دهید.توجه کنید که آدرس Repository
                    جدیدی که وارد می کنید دقیقا باید شامل همان repository و همان تاریخچه commit باشد در غیر این صورت
                    سیستم deploy عمل نخواهد کرد!
                </div>
                <div class="form-group row">
                    <label for="repository" class="col-md-3 col-form-label text-right">Repository</label>
                    <div class="col-md-8">
                        <input name="repo" type="text" value="{{$site->repo}}"
                                                 class="form-control text-left dir-ltr">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success" type="submit"><span>تغییر Git Remote</span></button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modal-last-deployment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deployment Log</h4>
                </div>
                <div class="modal-body">
                    <div class="overlay btn-lg">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">بستن</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        $('#show_deployment_modal').on('click', function () {
            $('#modal-last-deployment .modal-body').load('{{route('deployments.lastDeploymentLog',['site_id'=>$site->id])}}', function () {
                console.log("done")
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> خانه</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

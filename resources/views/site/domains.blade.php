@extends('layouts.single_box')
@php($title="دامنه های متصل به سایت")
@php($sidebar="layouts.sidebars.site_sidebar")

@section('content')
    <div class="box">
        <form method="post" action="{{route('sites.park_domain',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    اتصال دامنه جدید
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    در این بخش می توانید یک یا چند دامنه را به سایت {{$site->name}} متصل کنید
                </div>
                <div class="form-group row">
                    <label for="command" class="col-md-3 col-form-label text-right">نام دامنه</label>
                    <div class="col-md-8">
                        <input id="name" required name="name" type="text" class="form-control text-left dir-ltr"
                               placeholder="johndoe.ir">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success" type="submit"><span>اتصال</span></button>
            </div>
        </form>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                لیست دامنه های سایت {{$site->name}}
            </div>
        </div>

        <div class="box-body">
            @if(count($domains) > 0)
                <table class="table">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>نام دامنه</th>
                        <th>تاریخ اتصال</th>
                        <th>وضعیت</th>
                        <th></th>
                    </tr>

                    @foreach($domains as $key=> $domain)
                        <tr>
                            <td>{{$key +1 }}.</td>
                            <td>{{$domain->name}}</td>
                            <td>{{$domain->created_at}}</td>
                            <td><span class="command_status bg-green">متصل</span></td>
                            <td>
                                <div class="input-group-btn col-md-1">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="fa  fa-ellipsis-v"></span></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="btn btn-default"
                                               onclick="return confirm('آیا از حذف دامنه {{$domain->name}} اطمینان دارید؟ ' )"
                                               href="{{route('sites.remove_domain',['site'=>$site , 'name'=>$domain->name])}}">حذف</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info Disabled">
                    تاکنون هیچ دامنه ای برای سایت {{$site->name}} تعریف نشده است
                </div>
            @endif

        </div>
    </div>


    <div class="box">
        <form method="post" action="{{route('sites.park_domain',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    زیردامنه پیش فرض
                </div>
            </div>
            <div class="box-body">
                @if($site->subdomain_status)
                    <div class="alert alert-info">
                        بصورت پیش فرض زیردامنه {{$site->name}}.gnulover.ir به سایت شما متصل گردیده است.
                    </div>
                @else
                    <div class="alert alert-warning">
                        در حال حاضر زیردامنه {{$site->name}}.gnulover.ir توسط شما غیرفعال شده است. شما می توانید آن را
                        مجددا فعال نمایید
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if($site->subdomain_status)
                    <a class="btn btn-warning" href="{{route('sites.disable_sub_domain',['site'=>$site])}}"><span>قطع اتصال</span></a>
                @else
                    <a class="btn btn-success" href="{{route('sites.enable_sub_domain',['site'=>$site])}}"><span>فعال سازی مجدد</span></a>
                @endif
            </div>
        </form>
    </div>
@stop

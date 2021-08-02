@extends('layouts.single_box')
@php($title="اجرای دستورات ")
@php($sidebar="layouts.sidebars.site_sidebar")

@section('content')
    <div class="box">
        <form method="post" action="{{route('sites.create_worker',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    صف (Queue)
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    در این قسمت به هر تعداد که نیاز دارید می توانید queue worker بسازید. worker ها بصورت خودکار توسط برنامه supervisor مانیتور خواهند شد و در صورت بروز مشکل، مجددا اجرا خواهند شد. تمامی worker در صورت restart کردن سرور، بطور اتوماتیک اجرا می شوند.
                </div>
                <div class="form-group row">
                    <label for="connection" class="col-md-3 col-form-label text-right">Connection</label>
                    <div class="col-md-8">
                        <input id="connection" name="connection" type="text" class="form-control text-left dir-ltr"
                               placeholder="redis" value="redis">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="queue" class="col-md-3 col-form-label text-right">Queue</label>
                    <div class="col-md-8">
                        <input id="queue" name="queue" type="text" class="form-control text-left dir-ltr"
                               placeholder="default" value="default">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="timeout" class="col-md-3 col-form-label text-right">Maximum Seconds Per Job</label>
                    <div class="col-md-8">
                        <input id="timeout" name="timeout" type="text" class="form-control text-left dir-ltr"
                               placeholder="60">
                        <p><small>(0 = No Timeout)</small></p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sleep" class="col-md-3 col-form-label text-right">Rest Seconds When Empty</label>
                    <div class="col-md-8">
                        <input id="sleep" name="sleep" type="text" class="form-control text-left dir-ltr"
                               placeholder="10">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="num_procs" class="col-md-3 col-form-label text-right">Processes (Optional)
                    </label>
                    <div class="col-md-8">
                        <input id="num_procs" name="num_procs" type="text" class="form-control text-left dir-ltr"
                               placeholder="1">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tries" class="col-md-3 col-form-label text-right">Maximum Tries (Optional)</label>
                    <div class="col-md-8">
                        <input id="tries" name="tries" type="text" class="form-control text-left dir-ltr"
                               placeholder="1">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success" type="submit"><span>افزودن</span></button>
            </div>
        </form>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                لیست Worker ها
            </div>
        </div>

        <div class="box-body">
            @if(count($workers) > 0)
                <table class="table">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>صف</th>
                        <th>Timeout</th>
                        <th>تعداد پردازش</th>
                        <th>تلاش ها</th>
                        <th></th>
                    </tr>

                    @foreach($workers as $worker)
                        <tr>
                            <td>{{$worker->id }}.</td>
                            <td>
                                {{$worker->queue}}
                                <small>Connection: {{$worker->connection}}</small>
                            </td>
                            <td>{{$worker->timeout}}</td>
                            <td>{{$worker->num_procs}}</td>
                            <td>{{$worker->tries}}</td>
                            <td><a href="{{route('sites.remove_worker',['site'=>$site,'worker_id'=>$worker->id])}}" class="btn btn-danger"><i class="fa fa-remove" /></a> </td>

                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info Disabled">
                    تاکنون هیچ worker ای برای این سایت تعریف نکرده اید
                </div>
            @endif

        </div>
    </div>
@stop

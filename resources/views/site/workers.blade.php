@extends('layouts.single_box')
@php($title=__('message.workers-title'))
@php($sidebar="layouts.sidebars.site_sidebar")

@section('content')
    <div class="box">
        <form method="post" action="{{route('sites.create_worker',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    {{ __('message.workers-createworker-formbox-title')}}
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    {{ __('message.workers-createworker-formbox-info')}}
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
                        <p><small class="text-muted">(0 = No Timeout)</small></p>
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
                <button class="btn btn-success" type="submit"><span>{{ __('message.workers-createworker-formbox-footer-addsubmitbutton')}}</span></button>
            </div>
        </form>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                {{ __('message.workers-listworkercontent-title')}}
            </div>

            <div class="pull-left">
                <button id="check_workers_status" class="btn btn-default" data-toggle="modal"
                        data-target="#modal-workers">
                    Check Workers Status
                </button>
            </div>
        </div>

        <div class="box-body">
            @if(count($workers) > 0)
                <table class="table">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ __('message.workers-listworkercontent-table-queueth')}}</th>
                        <th>Timeout</th>
                        <th>{{ __('message.workers-listworkercontent-table-processcountth')}}</th>
                        <th>{{ __('message.workers-listworkercontent-table-effortsth')}}</th>
                        <th>Restart</th>
                        <th></th>
                    </tr>

                    @foreach($workers as $worker)
                        <tr>
                            <td>{{$worker->id }}.</td>
                            <td>
                                {{$worker->queue}}
                                <br/>
                                <small>Connection: {{$worker->connection}}</small>
                            </td>
                            <td>{{$worker->timeout}}</td>
                            <td>{{$worker->num_procs}}</td>
                            <td>{{$worker->tries}}</td>
                            <td>
                                <a class="btn btn-default bg-black"
                                   href="{{route('sites.restart_worker',['site'=>$site,'worker_id'=>$worker->id])}}"><i
                                        class="fa fa-refresh"></i></a>
                            </td>
                            <td>
                                <button class="btn btn-default show_worker_log" data-toggle="modal"
                                        data-target="#modal-workers" data-worker-id="{{$worker->id}}"><i
                                        class="fa fa-eye"></i></button>

                                <a href="{{route('sites.remove_worker',['site'=>$site,'worker_id'=>$worker->id])}}"
                                   class="btn btn-danger">
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info Disabled">
                    {{ __('message.workers-listworkercontent-table-none')}}
                </div>
            @endif

        </div>
    </div>

    <div class="modal fade" id="modal-workers">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Loading</h4>
                </div>
                <div class="modal-body">
                    <pre class="console"><code id="modal_content">
                            <div class="overlay btn-lg">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </code></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('message.workers-modalworker-closebutton')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        $('.show_worker_log').on('click', function () {
            let worker_id = $(this).data('worker-id');
            $(".modal-title").html("Queue Worker Log (#" + worker_id + ")")
            $('#modal_content').html("");
            $('#modal_content').load('{{route('sites.get_worker_log',['site'=>$site,'worker_id'=>'0'])}}' + worker_id, function () {
                console.log("done")
            });
        });

        $('#check_workers_status').on('click', function () {
            $(".modal-title").html("Queue Workers Status")
            $('#modal_content').html("");
            $('#modal_content').load('{{route('sites.get_workers_status',['site'=>$site])}}', function () {
                console.log("done")
            });
        });
    </script>
@stop

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.workers-breadcrumb-dashbord-homeaddress')}}</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

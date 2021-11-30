@extends('layouts.single_box')
@php($title= __('message.commands-title'))
@php($sidebar="layouts.sidebars.site_sidebar")

@section('content')
    <div class="box">
        <form method="post" action="{{route('sites.exec_command',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                {{ __('message.commands-exec-command')}}                    
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                {{ __('message.commands-exec-command-alert1')}}
                    <span class="text-red">/var/www/html</span>
                    {{ __('message.commands-exec-command-alert2')}}
                    <span class="text-red">root</span>
                    {{ __('message.commands-exec-command-alert3')}}
                </div>
                <div class="form-group row">
                    <label for="command" class="col-md-3 col-form-label text-right">{{ __('message.commands-exec-syntax')}}</label>
                    <div class="col-md-8">
                        <input id="command" required name="command" type="text" class="form-control text-left dir-ltr"
                               placeholder="ls -la">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success" type="submit"><span>{{ __('message.commands-exec-button')}}</span></button>
            </div>
        </form>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
            {{ __('message.commands-history-command-box-title')}}
            </div>
        </div>

        <div class="box-body">
            @if(count($commands_history) > 0)
                <table class="table">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ __('message.commands-history-command-box-table-thead-user')}}</th>
                        <th>{{ __('message.commands-history-command-box-table-thead-syntax')}}</th>
                        <th>{{ __('message.commands-history-command-box-table-thead-date')}}</th>
                        <th>{{ __('message.commands-history-command-box-table-thead-status')}}</th>
                        <th></th>
                    </tr>

                    @foreach($commands_history as $key=> $history)
                        <tr>
                            <td>{{$key +1 }}.</td>
                            <td>{{$history->user->name}}</td>
                            <td class="text-red">{{$history->command}}</td>
                            <td>{{$history->created_at}}</td>
                            <td> {!!  ($history->success)?'<span class="command_status bg-green">{{ __('message.commands-history-command-box-table-tbody-status-success')}}</span>':'<span class="command_status bg-red">{{ __('message.commands-history-command-box-table-tbody-status-faile')}}</span>' !!}</td>
                            <td>
                                <div class="input-group-btn col-md-1">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="fa  fa-ellipsis-v"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="show_output_modal" data-toggle="modal"
                                               data-target="#modal-output" data-command="{{$history->command}}" data-output="{{$history->output}}" href="#">{{ __('message.commands-history-command-box-table-tbody-panelbutton-history-output')}}
                                                </a></li>
                                        <li>
                                            <a href="#1" onclick="document.getElementById('form_{{$history->id}}').submit()" >{{ __('commands-history-command-box-table-tbody-panelbutton-run-again')}}</a>
                                            <form method="post"
                                                  id="form_{{$history->id}}"
                                                  action="{{route('sites.exec_command',['site'=>$site])}}">
                                                @csrf
                                                <input type="hidden" name="command" value="{{$history->command}}"/>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info Disabled">
                   {{ __('message.commands-history-command-box-table-tbody-panelbutton-null')}}
                </div>
            @endif

        </div>
    </div>

    <div class="modal fade" id="modal-output">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ __('message.commands-history-command-resultbox-title')}} <small class="text-muted" id="command-content"></small></h4>
                </div>
                <div class="modal-body">
                    <pre class="console"><code id="output-content"></code></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('message.commands-history-command-resultbox-footerbutton')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        $('.show_output_modal').on('click', function () {
            $('#output-content').html($(this).data('output'))
            $('#command-content').html($(this).data('command'))
        });
    </script>
@stop

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.commands-breadcrumb-homeaddress')}}</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

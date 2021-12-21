@extends('layouts.single_box')
@php($title=__('message.show-title').$site->name)
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
                {{ __('message.show-contentbox-info')}}
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button id="show_deployment_modal" class="btn btn-default" data-toggle="modal"
                    data-target="#modal-last-deployment">{{ __('message.show-contentbox-footer-lastdeploymentreport-button')}}
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
                        {{ __('message.show-formbox-description')}}
                    </small>
                </div>
            </div>
            <div class="box-body">
                <textarea dir="ltr" class="col-md-12" style="height: 15em"
                          name="deploy_commands">{{$site->deploy_commands}}</textarea>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-success">{{ __('message.show-formbox-footer-submitbutton')}}</button>
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
            {{ __('message.show-deploytriggerurlbox-description')}}
            <div class="alert alert-warning text-left">
                <a href="{{route('triggerDeployment',['token'=> $site->deploy_token])}}">{{route('triggerDeployment',['token'=> $site->deploy_token])}}</a>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a class="btn btn-success" href="{{route('sites.regenerate_deploy_token',['site'=>$site])}}">{{ __('message.show-deploytriggerurlbox-footer-button')}}</a>
        </div>
    </div>

    @if($maintenace_status)
        <div class="box">
            <form method="post" action="{{route('sites.maintenance_up',['site'=> $site])}}">
                @csrf
                <div class="box-header with-border">
                    <div class="pull-right">
                        {{ __('message.show-maintenace-status-formbox-maintenaceup-title')}}
                    </div>
                </div>
                <div class="box-body">
                    <div class="alert alert-warning">
                        <p> {{ __('message.show-maintenace-status-formbox-warningcontent')}}</p>
                    </div>
                    <p class="text-left text-center"><a target="_blank"
                                                        href="http://{{$site->name}}{{config('larahost.sudomain')}}/{{$maintenace_secret}}">http://{{$site->name}}
                            {{config('larahost.sudomain')}}/{{$maintenace_secret}}</a></p>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-success"
                    ><span>{{ __('message.show-maintenace-status-formbox-footer-cancelsubmitbutton')}}</span></button>
                </div>
            </form>
        </div>
    @else
        <div class="box">
            <form method="post" action="{{route('sites.maintenance_down',['site'=>$site])}}">
                @csrf
                <div class="box-header with-border">
                    <div class="pull-right">
                        {{ __('message.show-maintenace-status-formbox-maintenacedown-title')}}
                    </div>
                </div>
                <div class="box-body">
                    <div class="alert alert-info">
                        {{ __('message.show-maintenace-status-formbox-infocontent')}}
                    </div>
                    <div class="form-group row"><label for="secret" class="col-md-3 col-form-label text-md-right">
                            {{ __('message.show-maintenace-status-formbox-secretinput-link')}}
                        </label>
                        <div class="col-md-8"><input type="text" id="secret" name="secret" class="form-control dir-ltr"> <span
                                class="form-text">{{ __('message.show-maintenace-status-formbox-secretinput-text1')}}  <a
                                    href="https://laravel.com/docs/8.x/configuration#bypassing-maintenance-mode"
                                    target="_blank">{{ __('message.show-maintenace-status-formbox-secretinput-link')}}</a> {{ __('message.show-maintenace-status-formbox-secretinput-text2')}}</span></div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" href="{{route('sites.maintenance_down',['site'=>$site])}}"
                            class="btn btn-warning"
                    ><span>{{ __('message.show-maintenace-status-formbox-footer-activesubmitbutton')}}</span></button>
                </div>
            </form>
        </div>
    @endif

    <div class="box">
        <form method="post" action="{{route('sites.update_git_remote',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    {{ __('message.show-maintenace-status-formbox-gitremote-title')}}
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    {{ __('message.show-maintenace-status-formbox-gitremote-info')}}
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
                <button class="btn btn-success" type="submit"><span>{{ __('message.show-maintenace-status-formbox-footer-gitremotesubmitbutton')}}</span></button>
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
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ __('message.show-maintenace-status-deploymentlog-closemodal')}}</button>
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
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.show-breadcrumb-dashboard-homeaddress')}}</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

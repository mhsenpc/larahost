@extends('layouts.single_box')
@php($title=__('message.domains-title'))
@php($sidebar="layouts.sidebars.site_sidebar")

@section('content')
    <div class="box">
        <form method="post" action="{{route('sites.park_domain',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    {{ __('message.domains-formbox-header-title')}}
                </div>
            </div>
            <div class="box-body">
                <div class="alert alert-info">
                    {{ __('message.domains-formbox-body-title1')}} {{$site->name}} {{ __('message.domains-formbox-body-title2')}}
                </div>
                <div class="form-group row">
                    <label for="command" class="col-md-3 col-form-label text-right">{{ __('message.domains-formbox-namedomain-label')}}</label>
                    <div class="col-md-8">
                        <input id="name" required name="name" type="text" class="form-control text-left dir-ltr"
                               placeholder="johndoe.ir">
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success" type="submit"><span>{{ __('message.domains-formbox-footer-submitbutton')}}</span></button>
            </div>
        </form>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                {{ __('message.domains-domainlist-title1')}} {{$site->name}} {{ __('message.domains-domainlist-title2')}}
            </div>
        </div>

        <div class="box-body">
            @if(count($domains) > 0)
                <table class="table">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>{{ __('message.domains-domainlist-table-nameth')}}</th>
                        <th>{{ __('message.domains-domainlist-table-connectiondateth')}}</th>
                        <th>{{ __('message.domains-domainlist-table-statusth')}}</th>
                        <th></th>
                    </tr>

                    @foreach($domains as $key=> $domain)
                        <tr>
                            <td>{{$key +1 }}.</td>
                            <td>{{$domain->name}}</td>
                            <td>{{$domain->created_at}}</td>
                            <td><span class="command_status bg-green">{{ __('message.domains-domainlist-table-statustd')}}</span></td>
                            <td>
                                <div class="input-group-btn col-md-1">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                        <span class="fa  fa-ellipsis-v"></span></button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="btn btn-default"
                                               onclick="return confirm('{{ __('message.domains-domainlist-table-removebutton-alert1')}} {{$domain->name}} {{ __('message.domains-domainlist-table-removebutton-alert2')}} ' )"
                                               href="{{route('sites.remove_domain',['site'=>$site , 'name'=>$domain->name])}}">{{ __('message.domains-domainlist-table-removebutton-linktitle')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info Disabled">
                    {{ __('message.domains-domainlist-none1')}} {{$site->name}} {{ __('message.domains-domainlist-none2')}}
                </div>
            @endif

        </div>
    </div>


    <div class="box">
        <form method="post" action="{{route('sites.park_domain',['site'=>$site])}}">
            @csrf
            <div class="box-header with-border">
                <div class="pull-right">
                    {{ __('message.domains-parkdomain-formbox-header')}}
                </div>
            </div>
            <div class="box-body">
                @if($site->subdomain_status)
                    <div class="alert alert-info">
                        {{ __('message.domains-parkdomain-formbox-status-info1')}} {{$site->name}}{{config('larahost.sudomain')}} {{ __('message.domains-parkdomain-formbox-status-info2')}}
                    </div>
                @else
                    <div class="alert alert-warning">
                        {{ __('message.domains-parkdomain-formbox-status-warning')}} {{$site->name}}{{config('larahost.sudomain')}} {{ __('message.domains-parkdomain-formbox-status-warning2')}}
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                @if($site->subdomain_status)
                    <a class="btn btn-warning" href="{{route('sites.disable_sub_domain',['site'=>$site])}}"><span>{{ __('message.domains-parkdomain-formbox-footer-disablebutton')}}</span></a>
                @else
                    <a class="btn btn-success" href="{{route('sites.enable_sub_domain',['site'=>$site])}}"><span>{{ __('message.domains-parkdomain-formbox-footer-enablebutton')}}</span></a>
                @endif
            </div>
        </form>
    </div>
@stop

@section('breadcrumb')
    <li >
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.domains-breadcrumb-dashbord-homeaddress')}}</a>
    </li>

    <li >
        <a href="{{route('sites.show',compact('site'))}}"> {{$site->name}}</a>
    </li>

    <li class="active">
        <a href="{{url()->current()}}"> {{$title}}</a>
    </li>
@endsection

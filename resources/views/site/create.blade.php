@extends('layouts.single_box')
@php($title="ایجاد سایت جدید")
@section('content')
    @if(!$allowNewSite)
        <div class="alert alert-warning">
            {{ __('message.create-allownewsite-alert')}}
        </div>
    @endif

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('message.create-formbox-header-title')}}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->


        <form action="{{route('sites.store')}}" method="post">
            <div class="box-body">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('message.create-formbox-name-label')}}</label>
                    <input type="text" name="name" id="name" class="form-control dir-ltr" required
                           placeholder="my_beautiful_gallery" value="{{$faker->domainWord }}">
                </div>

                <div class="form-group">
                    <label for="repo">{{ __('message.create-formbox-repository-label')}}</label>
                    <input type="text" name="repo" id="repo" value="https://github.com/laravel/laravel"
                           class="form-control dir-ltr" required placeholder="https://github.com/laravel/laravel">
                </div>

                <!-- checkbox -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="manual_credentials" id="manual_credentials" value="1">
                        {{ __('message.create-formbox-checkbox-value1-title')}}
                    </label>

                </div>

                <div class="nav-tabs-custom lara_hidden" id="private_repository">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#ssh_key" data-toggle="tab">{{ __('message.create-formbox-navtabs-sshkey-links-title)}}</a></li>
                        <li><a href="#basic_auth" data-toggle="tab">{{ __('message.create-formbox-navtabs-basicauth-links-title)}}</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="active tab-pane" id="ssh_key">
                            <div class="row">
                                <div class="callout callout-info">
                                    <h4>{{ __('message.create-formbox-tabcontent-sshkey-calloutinfo-header')}} </h4>

                                    <p> {{ __('message.create-formbox-tabcontent-sshkey-calloutinfo-content')}} </p>
                                    <p class="text-left dir-ltr" style="word-break: break-all;">
                                        {{$public_key}}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="basic_auth">
                            <div class="row">
                                <div class="callout callout-warning">
                                    <h4>{{ __('message.create-formbox-tabcontent-basicauth-calloutwarning-header')}} </h4>

                                    <p>{{ __('message.create-formbox-tabcontent-basicauth-calloutwarning-content')}}</p>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <label for="username">{{ __('message.create-formbox-tabcontent-basicauth-username-label-title')}}</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="username" id="username" value="">
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <label for="password">{{ __('message.create-formbox-tabcontent-basicauth-password-label-title')}}</label>
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
                    <input type="submit" value="{{ __('message.create-formbox-boxfooter-submitvalue-input')}}" class="btn btn-primary"
                           @if(!$allowNewSite) disabled @endif/>
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
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> {{ __('message.create-breadcrumb-dashbord-homeaddress-title')}}</a>
    </li>

    <li >
        <a href="{{route('sites.index')}}"> {{ __('message.create-breadcrumb-mysitesaddress-title')}}</a>
    </li>

    <li class="active">
        <a > {{ __('message.create-breadcrumb-createnewsiteaddress-title')}}</a>
    </li>
@endsection

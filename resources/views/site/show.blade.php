@extends('layouts.single_box')
@php($title="وضعیت سایت ".$site->name)
@php($sidebar="layouts.site_sidebar")

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Deployment
            </div>
            <div class="box-tools pull-left">
                <a href="{{route('sites.redeploy',['site'=>$site])}}" type="button" class="btn btn-success">Deploy Now</a>
            </div>
        </div>
        <div class="box-body">
            <div class="alert alert-info">
                If you want push to deploy for your custom Git site, setup a post-commit trigger on your source control
                provider using the Deployment Trigger URL listed below.
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-default">VIEW LATEST DEPLOYMENT LOG</button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Deploy Script
            </div>
        </div>
        <div class="box-body">
            <textarea dir="ltr" class="col-md-12" style="height: 15em" name="deploy_commands">{{$site->deploy_commands}}</textarea>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-success">Update</button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Deployment Trigger URL
            </div>
        </div>
        <div class="box-body">
            Using a custom Git service, or want a service like Chipper CI to run your tests before your application is deployed to Forge? It's simple. When you commit fresh code, or when your continuous integration service finishes testing your application, instruct the service to make a GET or POST request to the following URL. Making a request to this URL will trigger your Forge deployment script:
<a >https://forge.laravel.com/servers/310282/sites/832343/deploy/http?token=hV4uZPsw8epR2ggshy3Zu9XEmaBmobmy9lInTP2s</a>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-success">REFRESH SITE TOKEN</button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Maintenance Mode
            </div>
        </div>
        <div class="box-body">
            <div class="form-group row"><label for="secret" class="col-md-3 col-form-label text-md-right">Secret</label> <div class="col-md-8"><input type="text" id="secret" class="form-control"> <span class="form-text">Laravel 8 applications can make use of the <a href="https://laravel.com/docs/8.x/configuration#bypassing-maintenance-mode" target="_blank">secret option</a>.</span></div></div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-danger" type="button"><span >Enable Maintenance Mode</span></button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Deployment Branch
            </div>
        </div>
        <div class="box-body">
            <div class="alert alert-info">
                Forge uses this branch to gather details of the latest commit when you deploy your application. You should verify that this branch matches the branch in your deployment script and the branch that is actually deployed on your server
            </div>
            <div class="form-group row"><label for="repository" class="col-md-3 col-form-label text-md-right">Branch</label> <div class="col-md-8"><input type="text" value="master" class="form-control"></div></div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-success" type="button"><span >Update Branch</span></button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Update Git Remote
            </div>
        </div>
        <div class="box-body">
            <div class="alert alert-info">
                This panel allows you to update the Git remote URL on your server; however, the site will not be removed or become unavailable during the process. The updated Git remote must contain the same repository / Git history as the currently installed repository. You should not use this function to install an entirely different project onto this site. If you would like to install an entirely different project, you should completely uninstall the existing repository using the "Uninstall Repository" button below.
            </div>
            <div class="form-group row"><label for="repository" class="col-md-3 col-form-label text-md-right">Repository</label> <div class="col-md-8"><input type="text" value="git@gitlab.com:mohsengituser/calltrackingwebsite.git" class="form-control"></div></div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-success" type="button"><span >Update Git Remote</span></button>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="pull-right">
                Uninstall Repository
            </div>
        </div>
        <div class="box-body">
            <div class="alert alert-warning">
                Uninstalling a repository will reset the site back to its original state, which shows Forge's default site page.
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-danger" type="button"><span >Uninstall Repository</span></button>
        </div>
    </div>

    <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown link
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
        </div>
    </div>
        <a class="btn btn-secondary" href="{{route('sites.restart',['site'=>$site])}}">Restart Site</a>

@stop

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
                <a href="{{route('sites.redeploy',['site'=>$site])}}" type="button" class="btn btn-success">Deploy
                    Now</a>
            </div>
        </div>
        <div class="box-body">
            <div class="alert alert-info">
                اکر انتظار دارید که به محض push کردن در نرم افزار کنترل نسخه، عملیات deploy شروع شود، لازم است که تریگر
                مربوطه که در بخش Deployment Trigger URL وجود دارد را تنظیم نمایید
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button id="show_deployment_modal" class="btn btn-default" data-toggle="modal" data-target="#modal-last-deployment">دیدن گزارش آخرین Deployment</button>
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

    <?php /*
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
    */ ?>

    <div class="row" >
        <div class="input-group-btn col-md-1">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Files
                <span class="fa fa-caret-down"></span></button>
            <ul class="dropdown-menu">
                <li><a href="#">ویرایش فایل ENV</a></li>
                <li><a href="#">ویرایش تنظیمات Apache</a></li>
            </ul>
        </div>

        <div class="input-group-btn col-md-1">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Restart
                <span class="fa fa-caret-down"></span></button>
            <ul class="dropdown-menu">
                <li><a href="{{route('sites.restart_all',['site'=>$site])}}">Restart Server</a></li>
                <li><a href="#">Restart Apache</a></li>
                <li><a href="#">Restart Mysql</a></li>
                <li><a href="#">Restart Redis</a></li>
                <?php /* <li><a href="#">Restart Supervisor</a></li> */ ?>
            </ul>
        </div>

        <div class="input-group-btn col-md-1">
            <form method="post" action="{{route('sites.remove',['site'=> $site])}}">
                @csrf
                <input type="submit" class="btn btn-default" value="Delete Site"
                       onclick="return confirm('آیا از حذف سایت {{$site->name}} اطمینان دارید؟ این عملیات غیرقابل بازگشت است!' )"/>
            </form>
        </div>

    </div>

    <div class="clearfix">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
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
        $('#show_deployment_modal').on('click',function(){
            $('#modal-last-deployment .modal-body').load('{{route('deployments.lastDeploymentLog',['site_id'=>$site->id])}}',function(){
                console.log("done")
            });
        });
    </script>
@stop

<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-right image">
        <img src="{{asset('dist/img/avatar.png')}}" class="img-circle" alt="User Image" />
    </div>
    <div class="pull-right info">
        <p>{{$site->name}}</p>
        @if($running)
        <a href="#"><i class="fa fa-circle text-success"></i> روشن</a>
        @else
            <a href="#"><i class="fa fa-circle text-danger"></i> خاموش</a>
        @endif
    </div>
</div>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">منو</li>
    <li >
        <a href="{{route('sites.index')}}">
            <i class="fa fa-arrow-right"></i> <span>بازگشت به لیست سایت ها</span>
        </a>
    </li>
    <li >
        <a href="{{route('sites.show',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>وضعیت</span>
        </a>
    </li>
    <li >
        <a href="{{route('sites.deploy_commands',['site'=> $site])}}">
            <i class="fa fa-circle"></i> <span>Deploy Commands</span>
        </a>
    </li>
    <li >
        <a href="{{route('sites.deployments',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>Deployments</span>
        </a>
    </li>
    <li >
        <a href="{{route('sites.logs',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>Laravel Logs</span>
        </a>
    </li>
    <li >
        <a href="{{route('sites.show_remove',['site'=> $site])}}">
            <i class="fa fa-remove text-red"></i> <span>حذف سایت</span>
        </a>
    </li>
</ul>

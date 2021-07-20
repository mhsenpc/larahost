<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-right image">
        <img src="{{asset('dist/img/server.png')}}"/>
    </div>
    <div class="pull-right info">
        <p>
            {{$site->name}}
            <a target="_blank" href="http://{{$site->name}}.gnulover.ir">
                <i class="fa fa-arrow-circle-right text-green"></i>
            </a>
        </p>
        @if($running)
            <a><i class="fa fa-circle text-success"></i> روشن</a>
        @else
            <a><i class="fa fa-circle text-danger"></i> خاموش</a>
        @endif
    </div>
    <div class="pull-left">
        <img src="{{asset('dist/img/iran_flag.png')}}" width="50em" />
    </div>
</div>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">منو</li>
    <li>
        <a href="{{route('sites.index')}}">
            <i class="fa fa-arrow-right"></i> <span>بازگشت به لیست سایت ها</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.show',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>میزکار سایت</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.env_editor',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>Environment</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.deployments',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>Deployments</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.logs',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>Laravel Logs</span>
        </a>
    </li>
</ul>

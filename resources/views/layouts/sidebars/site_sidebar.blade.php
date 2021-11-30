<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-right image">
        <img src="{{asset('dist/img/server.png')}}"/>
    </div>
    <div class="pull-right info">
        <p>
            {{$site->name}}
            <a target="_blank" href="http://{{$site->name}}{{config('larahost.sudomain')}}">
                <i class="fa fa-arrow-circle-right text-green"></i>
            </a>
        </p>
        @if($running)
            <a><i class="fa fa-circle text-success"></i> {{ __('message.site-sidebar-off')}}</a>
        @else
            <a><i class="fa fa-circle text-danger"></i> {{ __('message.site-sidebar-on')}}</a>
        @endif
    </div>
    <div class="pull-left">
        <img src="{{asset('dist/img/iran_flag.png')}}" width="50em" />
    </div>
</div>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">{{ __('message.site-sidebar-menu-title')}}</li>
    <li>
        <a href="{{route('sites.index')}}">
            <i class="fa fa-arrow-right"></i> <span>{{ __('message.site-sidebar-return-to-my-sites')}}</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.show',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>{{ __('message.site-sidebar-site-desktop')}}</span>
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
        <a href="{{route('sites.commands',['site'=> $site])}}">
            <i class="fa fa-circle"></i> <span>{{ __('message.site-sidebar-syntax')}}</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.logs',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>{{ __('message.site-sidebar-reports')}}</span>
        </a>
    </li>
    <li>
        <a href="{{route('sites.domains',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>{{ __('message.site-sidebar-domains')}}</span>
        </a>
    </li>

    <li>
        <a href="{{route('sites.workers',['site'=>$site])}}">
            <i class="fa fa-circle"></i> <span>Queue</span>
        </a>
    </li>
</ul>

<script>
    window.channel.bind('site.deployed', function(data) {
        var site_name = "{{$site->name}}";
        if(site_name == data.site_name){
            window.document.title = "{{$title}}";
        }
    });
</script>

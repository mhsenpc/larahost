<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-right image">
        <img src="{{asset('dist/img/avatar.png')}}" class="img-circle" alt="User Image"/>
    </div>
    <div class="pull-right info">
        <p>{{auth()->user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i>{{ __('message.main-sidebar-userpanel-onlinelink')}}</a>
    </div>
</div>
<!-- search form -->
<form action="{{route('search')}}" method="get" class="sidebar-form">
    @method('post')
    <div class="input-group">
        <input type="text" list="sites" name="site_name" class="form-control" placeholder="{{ __('message.main-sidebar-form-inputsitename-placeholder')}}" />
        <datalist id="sites">
            @foreach($user_sites as $site)
            <option value="{{$site->name}}">
            @endforeach
        </datalist>
        <span class="input-group-btn">
                                <button type="submit"  id="search-btn" class="btn btn-flat"><i
                                        class="fa fa-search"></i></button>
                            </span>
    </div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">{{ __('message.main-sidebar-sidebarmenu-header')}}</li>
    <li>
        <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>{{ __('message.main-sidebar-menu-dashbord-title')}}</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span>{{ __('message.main-sidebar-menu-dashbord-mysite-link')}}</span>
            <span class="pull-left-container">
                                    <span class="label label-primary pull-left">{{count($user_sites)}}</span>
                                </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{route('sites.create')}}"><i class="fa fa-plus-circle"></i> {{ __('message.main-sidebar-menu-dashbord-newsite-link')}}</a>
            </li>
            @foreach($user_sites as $site)
                <li>
                    <a href="{{route('sites.show',['site'=>$site])}}"><i class="fa fa-circle-o"></i> {{$site->name}}</a>
                </li>
            @endforeach
            <li>
                <a href="{{route('sites.index')}}"><i class="fa fa-list"></i> {{ __('message.main-sidebar-menu-dashbord-allsite-link')}}</a>
            </li>
        </ul>
    </li>
    @if(auth()->user()->isAdmin())
        <li>
            <a href="{{route('admin.users.index')}}">
                <i class="fa fa-list"></i> <span>{{ __('message.main-sidebar-menu-dashbord-userslist-link')}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('admin.domains.index')}}">
                <i class="fa fa-list"></i> <span>{{ __('message.main-sidebar-menu-dashbord-domainslist-link')}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('admin.sites.index')}}">
                <i class="fa fa-list"></i> <span>{{ __('message.main-sidebar-menu-dashbord-siteslist-link')}}</span>
            </a>
        </li>
    @endif
</ul>

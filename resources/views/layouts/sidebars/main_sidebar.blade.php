<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-right image">
        <img src="{{asset('dist/img/avatar.png')}}" class="img-circle" alt="User Image" />
    </div>
    <div class="pull-right info">
        <p>{{auth()->user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
    </div>
</div>
<!-- search form -->
<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="جستجو" />
        <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
    </div>
</form>
<!-- /.search form -->
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">منو</li>
    <li >
        <a href="{{route('dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>میزکار</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span>سایت های من</span>
            <span class="pull-left-container">
                                    <span class="label label-primary pull-left">{{count($user_sites)}}</span>
                                </span>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{route('sites.create')}}"><i class="fa fa-plus-circle"></i> سایت جدید</a>
            </li>
            @foreach($user_sites as $site)
                <li>
                    <a href="{{route('sites.show',['site'=>$site])}}"><i class="fa fa-circle-o"></i> {{$site->name}}</a>
                </li>
            @endforeach
            <li>
                <a href="{{route('sites.index')}}"><i class="fa fa-list"></i> همه سایت ها</a>
            </li>
        </ul>
    </li>
</ul>

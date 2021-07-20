<div class="box align-bottom">
    <div class="box-header with-border">
        <div class="pull-right">
            کنترل سایت
        </div>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="input-group-btn col-md-1">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Files
                <span class="fa fa-caret-down"></span></button>
            <ul class="dropdown-menu">
                <li><a href="{{route('sites.env_editor',['site'=>$site])}}">ویرایش فایل ENV</a></li>
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

</div>

<div class="clearfix">
    <br/>
    <br/>
</div>

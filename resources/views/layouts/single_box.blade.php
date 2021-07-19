@extends('layouts.app')
@section('content')
<!-- Default box -->
<div class="box box-primary">
    <div class="box-header with-border">
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
        @yield('box_content')
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
@stop

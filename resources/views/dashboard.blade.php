@extends('layouts.single_box')
@php($title="داشبورد")

@section('box_content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>
        به لاراهاست خوش آمدید
    </p>

    @isset($is_admin)
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$sites_count}}</h3>

                    <p>تعداد سایت ها</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{route('sites.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$users_count}}</h3>

                    <p>کاربران ثبت شده</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{route('admin.users.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
    </div>
    @endisset
@endsection

@section('breadcrumb')
    <li class="active">
        <a class="fa fa-dashboard" href="{{route('dashboard')}}"> میزکار</a>
    </li>
@endsection

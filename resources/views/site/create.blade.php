@extends('layouts.app')

@section('content')
    <form action="{{route('sites.store')}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-2">
                <label for="name">name</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="name" id="name" required>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2">
                <label for="repo">repo</label>
            </div>
            <div class="col-md-4">
                <input type="text" name="repo" id="repo" value="https://github.com/laravel/laravel" required>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2">

            </div>
            <div class="col-md-4">
                <input type="checkbox" name="manual_credentials" id="manual_credentials" value="1"   >
                <label for="manual_credentials">Manual Credentials</label>
            </div>
        </div>

        <div id="manual_credentials_area" class="hidden" >
            <div class="row justify-content-center">
                <div class="col-md-2">
                    <label for="username">Username</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="username" id="username" value="">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-2">
                    <label for="password">Password</label>
                </div>
                <div class="col-md-4">
                    <input type="password" name="password" id="password" value="">
                </div>
            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-md-2">
                <input type="submit" value="create" class="btn btn-primary"/>
            </div>

        </div>
    </form>

    <script>
        $(document).ready(function (){
            $('#manual_credentials').change(function() {
                if(this.checked){
                    $("#manual_credentials_area").show();
                }
                else{
                    $("#manual_credentials_area").hide();
                }
            });
        });
    </script>
@stop

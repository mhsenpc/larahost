<?php


namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController {
    public function index(){
        $users = User::query()->orderBy('created_at','desc')->paginate();
        return view('admin.users',compact('users'));
    }

    public function loginAs(int $user_id){
        Auth::loginUsingId($user_id);
        return redirect('/');
    }
}

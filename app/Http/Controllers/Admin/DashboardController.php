<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function registered_users(){

        $users= User::all();
        return view ('Admin.registered_users')->with('users',$users);

    }

    public function edit_users(Request $request ,$id){

        $users = User::find($id);
        return view('Admin.edit_users')->with('users',$users);
    }
}

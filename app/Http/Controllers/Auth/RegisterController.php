<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin;

class RegisterController extends Controller
{
    public function ShowRegisterForm(){
        return view('auth/register');
    }

    public function register(Request $request) {
        $admin = $request->all();
        $admin['password'] = bcrypt($admin['password']);
        $admin = Admin::create($admin);
        return back();
    }
}
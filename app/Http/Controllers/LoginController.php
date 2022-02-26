<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/admin/dashboard');
        } else {
            return view('/admin/login.index');
        }
    }

    public function postLogin(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('admin/dashboard');
        }else{
            return redirect('admin/login')->with('alert', 'Email atau password salah');
        }
        return redirect('admin/login');
    }

    public function logOut(Request $request)
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}

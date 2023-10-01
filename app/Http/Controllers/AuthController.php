<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected function login()
    {
        return view('auth.login');
    }

    protected function register()
    {
        return view('auth.register');
    }

    protected function dashboard()
    {
        return view('dashboard.index');
    }
}

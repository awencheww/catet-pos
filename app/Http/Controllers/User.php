<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
    public function login()
    {
        return 'This is Login Page!';
    }

    public function register()
    {
        return 'This is Register Page!';
    }
}

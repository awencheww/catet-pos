<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    protected $inputType;
    protected function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request):RedirectResponse 
    {
        $this->inputType = filter_var($request->input('login_email_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$this->inputType => $request->input('login_email_username')]);
        $credentials = $request->validate([
            'email' => 'required_without:username|string|email|exists:users,email',
            'username' => 'required_without:email|string|exists:users,username',
            'password' => 'required',
        ]);
        $userAuth = Auth::attempt($credentials);
        if($userAuth) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Welcome '.$request->username.'!');
        }
        return redirect()->back()->with('error', 'Account Password is Incorrect.');
    }

    protected function register(): View
    {
        return view('auth.register');
    }

    public function customerRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|min:6',
            'username' => 'required|string|min:3|max:100|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:6|max:255|confirmed',
        ]);
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        Customer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'created_at' => now('Asia/Manila'),
        ]);
        return redirect()->back()->with('success', 'You are Successfully registered! Enjoy your Shopping.');
    }

    protected function dashboard(): View
    {
        return view('dashboard.index');
    }
}

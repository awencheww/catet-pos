<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AuthController extends Controller
{
    protected $inputType; //this is for filtering login input if email or username

    // login view
    protected function login(): View
    {
        return view('auth.login');
    }

    // login account serve as backend of login view
    public function authenticate(Request $request): RedirectResponse
    {
        $this->inputType = filter_var($request->input('login_email_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$this->inputType => $request->input('login_email_username')]);
        $credentials = $request->validate([
            'email' => 'required_without:username|string|email|exists:users,email',
            'username' => 'required_without:email|string|exists:users,username',
            'password' => 'required',
        ]);
        $userAuth = Auth::attempt($credentials);
        if ($userAuth) {
            $request->session()->regenerate();
            // redirect to homepage
            if (auth()->user()->role === 'admin' || auth()->user()->role === 'cashier') {
                return redirect('dashboard')->with('success', 'Welcome Admin/Cashier '.auth()->user()->username.'!');
            } else {
                return redirect()->intended()->with('success', 'Welcome our valued Customer '.auth()->user()->username.'!');
            }
        }

        return redirect()->back()->with('error', 'Account Password is Incorrect.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'cashier') {
            Auth::guard('web')->logout();

            return redirect('login');
        } else {
            Auth::guard('web')->logout();

            return redirect()->intended();
        }
    }

    // register view
    public function register(): View
    {
        return view('auth.register');
    }

    // register account serve as backend for register view or customer registration form
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

    // Forgot password
    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendResetPasswordLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view.
     */
    public function passwordResetRequest(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function passwordReset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}

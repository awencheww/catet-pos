<?php

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'customerRegister'])->name('customer.register');

    //forgot password
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('forgot-password', [AuthController::class, 'sendResetPasswordLink'])
        ->name('password.email');

    Route::get('reset-password/{token}', [AuthController::class, 'passwordResetRequest'])
        ->name('password.reset');

    Route::post('password-reset', [AuthController::class, 'passwordReset'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    //Customers
    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::get('/customer/forgot-password', [CustomerController::class, 'forgotPassword'])->name('customer.forgot.password');
    Route::post('/customer/update', [CustomerController::class, 'updateCustomer'])->name('customer.update');
});

Route::middleware('admin')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //User Admin or Cashier Routes
    Route::get('/users', [UserController::class, 'index'])->name('/users');
    Route::get('/user/edit/{id}', [UserController::class, 'editUser'])->name('/user/edit');
    Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
    Route::post('/user/destroy/{id}', [UserController::class, 'deleteUser'])->name('/user/destroy');

    // Admin Routes
    Route::get('/admin/settings', [UserController::class, 'adminSettings'])->name('admin.settings');
    Route::post('/adming/update', [UserController::class, 'updateSettings'])->name('admin.update');

    // Cashier Routes
    Route::get('/cashier/profile', [CashierController::class, 'profile'])->name('cashier.profile');
    Route::post('/user/update', [CashierController::class, 'updateCashier'])->name('cashier.update');
    Route::get('/cashier/forgot-password', [CashierController::class, 'forgotPassword'])->name('cashier.forgot.password');

    //User Customer Routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('/customers');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'editCustomer'])->name('/customer/edit');
    Route::post('/customer/update/{id}', [CustomerController::class, 'saveCustomer'])->name('/customer/update');
    Route::post('/customer/destroy/{id}', [CustomerController::class, 'deleteCustomer'])->name('/customer/destroy');
});

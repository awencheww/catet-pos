<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

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
// Homepage routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Guest add to tray
Route::post('/addtray', [HomeController::class, 'addTray'])->name('add.tray');

// Storefront
Route::get('/storefront/home', [HomeController::class, 'viewProducts'])->name('storefront.index');

// Authentication routes
Route::middleware('guest')->group(function () {

    // Login and Register routes
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
    Route::get('/customer/reset-password', [CustomerController::class, 'resetPassword'])->name('customer.reset.password');
    Route::post('/customer/update', [CustomerController::class, 'updateCustomer'])->name('customer.update');
});

Route::middleware('admin')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //User Admin or Cashier Routes
    Route::get('/users', [UserController::class, 'index'])->name('/users');
    Route::get('/user/add', [UserController::class, 'addUser'])->name('user.add');
    Route::post('/user/add/save', [UserController::class, 'storeUser'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'editUser'])->name('/user/edit');
    Route::post('/user/update/{id}', [UserController::class, 'updateUser'])->name('user.update');
    Route::post('/user/destroy/{id}', [UserController::class, 'deleteUser'])->name('/user/destroy');

    // Admin Routes
    Route::get('/admin/settings', [UserController::class, 'adminSettings'])->name('admin.settings');
    Route::post('/adming/update', [UserController::class, 'updateSettings'])->name('admin.update');
    Route::get('/admin/reset-password', [UserController::class, 'resetPassword'])->name('admin.reset.password');

    // Cashier Routes
    Route::get('/cashier/profile', [CashierController::class, 'profile'])->name('cashier.profile');
    Route::post('/user/update', [CashierController::class, 'updateCashier'])->name('cashier.update');
    Route::get('/cashier/reset-password', [CashierController::class, 'resetPassword'])->name('cashier.reset.password');

    //User Customer Routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('/customers');
    Route::get('/customer/add', [CustomerController::class, 'addCustomer'])->name('customer.add');
    Route::post('/customer/add/save', [CustomerController::class, 'storeCustomer'])->name('customer.store');
    Route::get('/customer/edit/{id}', [CustomerController::class, 'editCustomer'])->name('/customer/edit');
    Route::post('/customer/update/{id}', [CustomerController::class, 'saveCustomer'])->name('/customer/update');
    Route::post('/customer/destroy/{id}', [CustomerController::class, 'deleteCustomer'])->name('/customer/destroy');

    //Category
    Route::resource('categories', CategoryController::class);

    // Supplier
    Route::resource('suppliers', SupplierController::class);

    //Payment
    Route::resource('payments', PaymentController::class);

    // Product
    Route::resource('products', ProductController::class);

    //Storefront
    Route::post('/storefront/home', [ProductController::class, 'addTray'])->name('add.to.tray');
});

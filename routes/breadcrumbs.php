<?php

use App\Models\Cashier;
use App\Models\Category;
use App\Models\Customer;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard', ['icon' => 'bi bi-house-fill']));
});

// Home > Customers
Breadcrumbs::for('/customers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Customers', route('/customers'));
});

// Home > Customers > Add
Breadcrumbs::for('customer.add', function (BreadcrumbTrail $trail) {
    $trail->parent('/customers');
    $trail->push('Add Customer', route('customer.add'));
});

// Home > Customers > [edit]
Breadcrumbs::for('/customer/edit', function (BreadcrumbTrail $trail, $id) {
    $customer = Customer::findOrFail($id);
    $trail->parent('/customers');
    $trail->push($customer->name, route('/customer/edit', $customer->user_id));
});

// Customer Profile
Breadcrumbs::for('customer.profile', function (BreadcrumbTrail $trail) {
    $trail->push('Customer Profile', route('customer.profile'));
});


// Home > Users
Breadcrumbs::for('/users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('/users'));
});

// Home > Users > Add
Breadcrumbs::for('user.add', function (BreadcrumbTrail $trail) {
    $trail->parent('/users');
    $trail->push('Add User', route('user.add'));
});

// Home > Users > [edit]
Breadcrumbs::for('/user/edit', function (BreadcrumbTrail $trail, $id) {
    $cashier = Cashier::findOrFail($id);
    $trail->parent('/users');
    $trail->push($cashier->name, route('/user/edit', $cashier->user_id));
});

// Home > Admin
Breadcrumbs::for('admin.settings', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Admin settings', route('admin.settings'));
});

// Dashboard > categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Categories', route('categories.index'));
});
// Dashboard > categories > add
Breadcrumbs::for('categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Add Category', route('categories.create'));
});
// Dashboard > categories > edit
Breadcrumbs::for('categories.edit', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('categories');
    $trail->push($category->name, route('categories.edit', $category));
});

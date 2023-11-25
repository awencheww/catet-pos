<?php

use App\Models\Cashier;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
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
// Customer Tray
Breadcrumbs::for('customer.tray', function (BreadcrumbTrail $trail) {
    $trail->parent('customer.profile');
    $trail->push('Customer Tray', route('customer.tray'));
});
// Customer Orders
Breadcrumbs::for('customer.order', function (BreadcrumbTrail $trail) {
    $trail->parent('customer.profile');
    $trail->push('Your Orders', route('customer.order'));
});
// Customer Order History
Breadcrumbs::for('order.history', function (BreadcrumbTrail $trail) {
    $trail->parent('customer.profile');
    $trail->push('Your Order History', route('order.history'));
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
    $trail->push($category->category_name, route('categories.edit', $category));
});

// Dashboard > suppliers
Breadcrumbs::for('suppliers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Suppliers', route('suppliers.index'));
});
// Dashboard > suppliers > add
Breadcrumbs::for('suppliers.create', function (BreadcrumbTrail $trail) {
    $trail->parent('suppliers');
    $trail->push('Add Supplier', route('suppliers.create'));
});
// Dashboard > suppliers > edit
Breadcrumbs::for('suppliers.edit', function (BreadcrumbTrail $trail, Supplier $supplier) {
    $trail->parent('suppliers');
    $trail->push($supplier->contact_name, route('suppliers.edit', $supplier));
});

// Dashboard > payments
Breadcrumbs::for('payments', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('payments', route('payments.index'));
});
// Dashboard > payments > add
Breadcrumbs::for('payments.create', function (BreadcrumbTrail $trail) {
    $trail->parent('payments');
    $trail->push('Add Payment', route('payments.create'));
});
// Dashboard > payments > edit
Breadcrumbs::for('payments.edit', function (BreadcrumbTrail $trail, Payment $payment) {
    $trail->parent('payments');
    $trail->push($payment->method, route('payments.edit', $payment));
});

// Dashboard > products
Breadcrumbs::for('products', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Products', route('products.index'));
});
// Dashboard > products > add
Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products');
    $trail->push('Add Product', route('products.create'));
});
// Dashboard > products > edit
Breadcrumbs::for('products.edit', function (BreadcrumbTrail $trail, Product $product) {
    $trail->parent('products');
    $trail->push($product->product_name, route('products.edit', $product));
});

// Home > Storefront Products
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Homes', route('home'));
});

// Home > Storefront Products
Breadcrumbs::for('storefront.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('All Products', route('storefront.index'));
});


// Dashboard > Customer Orders
Breadcrumbs::for('admin.orders', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Customer Orders', route('admin.orders'));
});

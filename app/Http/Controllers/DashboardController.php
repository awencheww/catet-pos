<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\SalesOrder;

class DashboardController extends Controller
{
    // dashboard view
    public function dashboard(): View
    {
        $orders_count = User::whereHas('salesOrders', function ($query) {
            $query->where('sales_order.so_status', '=', 'preparing');
        })->count();
        return view('dashboard.index', compact('orders_count'));
    }
}

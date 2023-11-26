<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\SalesOrder;

class DashboardController extends Controller
{
    // dashboard view
    public function dashboard(): View
    {
        $orders_count = SalesOrder::all()->where('so_status', '=', 'preparing')->count();
        return view('dashboard.index', compact('orders_count'));
    }
}

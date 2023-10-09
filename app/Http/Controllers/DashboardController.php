<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // dashboard view
    public function dashboard(): View
    {
        return view('dashboard.index');
    }
}

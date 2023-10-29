<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index(Request $request)
    {
        // return view('cashier.index');
        $keyword = $request->get('search');
        $perPage = 5;
        if(!empty($keyword)) {
            $cashier = Cashier::where('name', 'LIKE', "%$keyword%")
                                ->orWhere('address', 'LIKE', "%$keyword%")
                                ->orWhere('phone_number', 'LIKE', "%$keyword%")
                                ->latest()->paginate($perPage);
        } else {
            $cashier = Cashier::latest()->paginate($perPage);
        }
        return view('cashier.index', ['cashier' => $cashier])->with('i', (request()->input('page', 1) - 1) * 5);
    }
}

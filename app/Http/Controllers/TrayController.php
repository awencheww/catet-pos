<?php

namespace App\Http\Controllers;

use App\Models\Tray;
use Illuminate\Http\Request;

class TrayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 30;
        if(auth()->user()) {
            $id = auth()->user()->id;
            //add tray
            $tray_count = Tray::query()->where('user_id', '=', $id)->get()->count();
            $tray = Tray::query()
                    ->rightJoin('products', 'products.id', '=', 'customer_tray.product_id')
                    ->select(
                        'products.id as product_id',
                        'customer_tray.id as tray_id',
                        'product_name',
                        'description',
                        'code',
                        'variant',
                        'image',
                        'quantity',
                        'unit_cost',
                        'total_cost',
                        'unit_price',
                        'expiry',
                    )
                    ->where('user_id', '=', $id)
                    ->latest('customer_tray.created_at')
                    ->fastPaginate($perPage);
        }
        return view('customer.customer-tray', compact('tray_count', 'tray'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Tray $tray)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tray $tray)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tray $tray)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Tray::destroy($id);
        return redirect()->back()->with('success', "Product remove from tray. ");
    }
}

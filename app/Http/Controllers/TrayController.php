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
        //
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
        dd($request);
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
    public function destroy(Tray $tray)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $suppliers = Supplier::query()
                            ->where('company', 'LIKE', "%$keyword%")
                            ->orWhere('contact_name', 'LIKE', "%$keyword%")
                            ->orWhere('email', 'LIKE', "%$keyword%")
                            ->orWhere('phone_number', 'LIKE', "%$keyword%")
                            ->orWhere('address', 'LIKE', "%$keyword%")
                            ->latest('created_at')->fastPaginate($perPage);
        } else {
            $suppliers = Supplier::query()->latest('created_at')
                            ->fastPaginate($perPage);
        }
        return view('dashboard.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Detect the needed input fields from the model
        $fields = (new Supplier())->getFillable();

        return view('dashboard.suppliers.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request using the detected input fields
        $validatedData = $request->validate([
            'company' => '',
            'contact_name' => 'required|string|max:255',
            'email' => 'email|string|unique:suppliers,email',
            'phone_number' => 'required|numeric|digits:11',
            'address' => 'required',
        ]);
        // Capitalize the first letter of the 'name' attribute
        $validatedData['company'] = ucwords($validatedData['company']);
        $validatedData['contact_name'] = ucwords($validatedData['contact_name']);
        $validatedData['address'] = ucwords($validatedData['address']);

        // Create a new category using the validated data
        Supplier::create($validatedData);
        return redirect()->back()->with("success", "Supplier Added Successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $fields = $supplier->getFillable();
        return view('dashboard.suppliers.edit', compact('fields', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        // Validate the request using the detected input fields
        $validatedData = $request->validate([
            'company' => 'string',
            'contact_name' => 'required|string|max:255',
            'email' => 'email|string|unique:suppliers,email,'.$supplier->id,
            'phone_number' => 'required|numeric|digits:11',
            'address' => 'required',
        ]);
        // Capitalize the first letter of the 'name' attribute
        $validatedData['company'] = ucwords($validatedData['company']);
        $validatedData['contact_name'] = ucwords($validatedData['contact_name']);
        $validatedData['address'] = ucwords($validatedData['address']);

        // Create a new category using the validated data
        $supplier->update($validatedData);
        return redirect()->back()->with("success", "Supplier Updated Successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Delete Permission denied!');
        }
        Supplier::destroy($supplier->id);
        return redirect()->back()->with('success', "Supplier successfully deleted.");
    }
}

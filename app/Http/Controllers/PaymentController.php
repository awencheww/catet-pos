<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $payments = Payment::query()
                            ->where('id', 'LIKE', "%$keyword%")
                            ->orWhere('purchase_order_id', 'LIKE', "%$keyword%")
                            ->orWhere('sales_order_id', 'LIKE', "%$keyword%")
                            ->orWhere('method', 'LIKE', "%$keyword%")
                            ->orWhere('status', 'LIKE', "%$keyword%")
                            ->orWhere('note', 'LIKE', "%$keyword%")
                            ->orWhere('created_at', 'LIKE', "%$keyword%")
                            ->latest('created_at')->fastPaginate($perPage);
        } else {
            $payments = Payment::query()->latest('created_at')
                            ->fastPaginate($perPage);
        }
        return view('dashboard.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Detect the needed input fields from the model
        $fields = (new Payment())->getFillable();
        //TODO: MAKE PO AND SO FOR RELATIONSHIP TO DISPLAY IN VIEW TO EDIT
        // $po = Category::query()->get();
        // $so = Supplier::query()->get();
        return view('dashboard.payments.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request using the detected input fields
        $validated = $request->validate([
            // 'purchase_order_id' => 'required|exists:purchase_order,id',
            'purchase_order_id' => 'required',
            // 'sales_order_id' => 'required|exists:sales_order,id',
            'sales_order_id' => 'required',
            'method' => 'required',
            'status' => 'required',
            'note' => 'string|max:255',
        ]);

        $payment = new Payment();
        $payment->purchase_order_id = $request->purchase_order_id;
        $payment->sales_order_id = $request->sales_order_id;
        $payment->method =  $request->method;
        $payment->status = $request->status;
        $payment->note = $request->note;

        $payment->saveOrFail();
        return redirect()->back()->with("success", "Payment Added Successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $fields = $payment->getFillable();
        //TODO: MAKE PO AND SO FOR RELATIONSHIP TO DISPLAY IN VIEW TO EDIT
        // $po = Category::query()->get();
        // $so = Supplier::query()->get();
        return view('dashboard.payments.edit', compact('fields', 'payment', 'po', 'so'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        // Validate the request using the detected input fields
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_order,id',
            'sales_order_id' => 'required|exists:sales_order,id',
            'method' => 'required',
            'status' => 'required',
        ]);

        $payment = new Payment();
        $payment->purchase_order_id = $request->purchase_order_id;
        $payment->sales_order_id = $request->sales_order_id;
        $payment->method = ($request->method !== 'cod' ? ucwords($request->method) : strtoupper($request->method));
        $payment->status = ucwords($request->status);
        $payment->note = $request->note;


        // Create a new category using the validated data
        $payment->update();
        return redirect()->back()->with("success", "Payment Updated Successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        Payment::destroy($payment->id);
        return redirect()->back()->with('success', "Payment successfully deleted.");
    }
}

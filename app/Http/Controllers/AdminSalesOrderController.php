<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\AdminSalesOrder;

class AdminSalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 30;
        $keyword = $request->get('search');
        if(auth()->user()) {
            $id = auth()->user()->id;
            //add tray
            $order_count = SalesOrder::query()->get('quantity')->count();
            $query = SalesOrder::query()
                    ->rightJoin('products', 'products.id', '=', 'sales_order.product_id')
                    ->rightJoin('categories', 'categories.id', '=', 'products.category_id')
                    ->rightJoin('payments', 'payments.sales_order_id', '=', 'sales_order.id')
                    ->select(
                        'transaction_number',
                        'sales_order.id as order_id',
                        'products.id as product_id',
                        'categories.id as categories_id',
                        'category_name',
                        'product_name',
                        'description',
                        'code',
                        'variant',
                        'image',
                        'sales_order.quantity as oder_quantity',
                        'unit_cost',
                        'total_cost',
                        'unit_price',
                        'expiry',
                        'so_status',
                        'sales_date',
                        'sales_invoice_number',
                        'payment_method',
                    )
                    ->where('so_status', '=', 'preparing')
                    ->latest('sales_order.sales_date');
            if(!empty($keyword)) {
                $query->orWhere('transaction_number', 'LIKE', "%$keyword%")
                    ->orWhere('product_name', 'LIKE', "%$keyword%")
                    ->orWhere('sales_invoice_number', 'LIKE', "%$keyword%")
                    ->orWhere('code', 'LIKE', "%$keyword%")
                    ->orWhere('products.id', 'LIKE', "%$keyword%")
                    ->orWhere('category_name', 'LIKE', "%$keyword%")
                    ->orWhere('company', 'LIKE', "%$keyword%")
                    ->orWhere('unit_cost', 'LIKE', "%$keyword%")
                    ->orWhere('order_quantity', 'LIKE', "%$keyword%")
                    ->orWhere('total_cost', 'LIKE', "%$keyword%")
                    ->orWhere('unit_price', 'LIKE', "%$keyword%")
                    ->orWhere('so_status', 'LIKE', "%$keyword%");
            }
            $orders = $query->fastPaginate($perPage);
        }
        return view('dashboard.orders.index', compact('order_count', 'orders'));
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
    public function store(Request $request, $order_id)
    {
        // Assuming $request is the request object containing your data
        $data = $request->all();
        // $prefix = auth()->user()->id;
        // $invoice_number = $prefix . substr(md5(uniqid()), 0, 8);
        // Loop through the arrays to save each sales order
        $existingOrder = SalesOrder::where('user_id', auth()->user()->id)
            ->where('sales_order.product_id', $request->product_id)
            ->where('so_status', 'preparing')
            ->first();

        if ($existingOrder) {
            // Update existing order with additional quantity, price, and change status
            $existingOrder->quantity = $request->quantity;
            $existingOrder->total_amount = $request->unit_price * $request->order_quantity;
            $existingOrder->net_total = $request->unit_price * $request->order_quantity;
            $existingOrder->sugar_content = $request->sugar_content ?? null;
            $existingOrder->writing = $request->writing ?? null;
            //     $existingOrder->writing = $data['writing'][$i] ?? null;
            //TODO: form sugar_content and writings if order is cake
            // if (isset($data['transaction_number'][$i]) && ($data['transaction_number'][$i] == $existingOrder->transaction_number)) {
            //     $existingOrder->sugar_content = $data['sugar_content'][$i] ?? null;
            //     $existingOrder->writing = $data['writing'][$i] ?? null;
            //     // Add any other fields you want to update here
            // }
            $existingOrder->so_status = 'complete';
            $existingOrder->save();
        }

        //update payments
        $payment = Payment::where('sales_order_id', $order_id)
            ->first();
        if($payment) {
            $payment->sales_order_id = $order_id;
            $payment->payment_method = $request->payment_method;
            $payment->sales_total_amount = $request->unit_price * $request->order_quantity;
            $payment->paid_amount = $request->unit_price * $request->order_quantity;
            $payment->status = 'paid';
            $payment->save();
        }
        // Payment::create([
        //     'sales_invoice_number' => $data['sales_invoice'][$i],
        //     'sales_order_id' => $data['order_id'][$i],
        //     'payment_method' => $data['payment_method'],
        //     'sales_total_amount' => $data['price'][$i] * $data['quantity'][$i],
        //     'paid_amount' => $data['price'][$i] * $data['quantity'][$i],
        //     'status' => 'paid',
        // ]);
        return redirect()->back()->with(['success' => 'Preparing your order.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesOrder $salesOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        //
    }
}

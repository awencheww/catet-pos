<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SalesOrder;
use App\Models\Tray;
use Illuminate\Http\Request;
use Symfony\Component\Uid\Command\GenerateUlidCommand;

class SalesOrderController extends Controller
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
            $order_count = SalesOrder::query()->where('user_id', '=', $id)->get('quantity')->count();
            $query = SalesOrder::query()
                    ->rightJoin('products', 'products.id', '=', 'sales_order.product_id')
                    ->rightJoin('categories', 'categories.id', '=', 'products.category_id')
                    ->select(
                        'transaction_number',
                        'sales_order.id as order_id',
                        'categories.id as categories_id',
                        'category_name',
                        'products.id as product_id',
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
                    )
                    ->where('user_id', '=', $id)
                    ->where('so_status', '=', 'pending')
                    ->orWhere('so_status', '=', 'preparing')
                    ->latest('sales_order.sales_date');
            if(!empty($keyword)) {
                $query->orWhere('transaction_number', 'LIKE', "%$keyword%")
                    ->orWhere('product_name', 'LIKE', "%$keyword%")
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
        return view('customer.customer-order', compact('order_count', 'orders'));
    }

    public function orderHistory()
    {
        $perPage = 30;
        if(auth()->user()) {
            $id = auth()->user()->id;
            //add tray
            $order_count = SalesOrder::query()->where('user_id', '=', $id)->get('quantity')->count();
            $query = SalesOrder::query()
                    ->rightJoin('products', 'products.id', '=', 'sales_order.product_id')
                    ->rightJoin('payments', 'payments.sales_order_id', '=', 'sales_order.id')
                    ->select(
                        'transaction_number',
                        'sales_order.id as order_id',
                        'products.id as product_id',
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
                    ->where('user_id', '=', $id)
                    ->where('so_status', '=', 'complete')
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
        return view('customer.customer-order-history', compact('order_count', 'orders'));
    }

    /**
     * Create sales order via checkout in customer tray
     */
    public function create(Request $request)
    {
        // Assuming $request is the request object containing your data
        $data = $request->all();
        $prefix = auth()->user()->id;
        $transaction_number = $prefix . substr(md5(uniqid()), 0, 8);

        // Loop through the arrays to save each sales order
        for ($i = 0; $i < count($data['product_id']); $i++) {
            $existingOrder = SalesOrder::where('user_id', auth()->user()->id)
                ->where('product_id', $data['product_id'][$i])
                ->where('so_status', 'pending')
                ->first();

            if ($existingOrder) {
                // Update existing order with additional quantity
                $existingOrder->quantity += $data['quantity'][$i];
                $existingOrder->total_amount = $existingOrder->price * $existingOrder->quantity;
                $existingOrder->net_total = $existingOrder->total_amount;
                $existingOrder->save();
                Tray::destroy($data['tray_id'][$i]); // remove from customer's tray
            } else {
                // Create a new sales order
                Tray::destroy($data['tray_id'][$i]); // remove from customer's tray
                SalesOrder::create([
                    'user_id' => auth()->user()->id,
                    'transaction_number' => $transaction_number,
                    'product_id' => $data['product_id'][$i],
                    'quantity' => $data['quantity'][$i],
                    'price' => $data['price'][$i],
                    'total_amount' => $data['price'][$i] * $data['quantity'][$i],
                    'net_total' => $data['price'][$i] * $data['quantity'][$i],
                    'so_status' => 'pending',
                ]);
            }
        }
        return redirect()->back()->with(['success' => 'Sales orders created successfully']);
    }

    /**
     * Complete Order
     */
    public function store(Request $request)
    {
        // Assuming $request is the request object containing your data
        $data = $request->all();
        $prefix = auth()->user()->id;
        $invoice_number = $prefix . substr(md5(uniqid()), 0, 8);
        // Loop through the arrays to save each sales order
        for ($i = 0; $i < count($data['product_id']); $i++) {
            $existingOrder = SalesOrder::where('user_id', auth()->user()->id)
                ->where('sales_order.product_id', $data['product_id'][$i])
                ->where('so_status', 'pending')
                ->first();

            if ($existingOrder) {
                // Update existing order with additional quantity, price, and change status
                $existingOrder->quantity = $data['quantity'][$i];
                $existingOrder->total_amount = $existingOrder->price * $existingOrder->quantity;
                $existingOrder->net_total = $existingOrder->total_amount;
                //TODO: form sugar_content and writings if order is cake
                // if (isset($data['transaction_number'][$i]) && ($data['transaction_number'][$i] == $existingOrder->transaction_number)) {
                //     $existingOrder->sugar_content = $data['sugar_content'][$i] ?? null;
                //     $existingOrder->writing = $data['writing'][$i] ?? null;
                //     // Add any other fields you want to update here
                // }
                $existingOrder->so_status = 'preparing';
                $existingOrder->save();
            }

            //create payments
            Payment::create([
                'sales_invoice_number' => $invoice_number,
                'sales_order_id' => $data['order_id'][$i],
                'payment_method' => $data['payment_method'],
                'sales_total_amount' => $data['price'][$i] * $data['quantity'][$i],
                'status' => 'preparing',
            ]);
        }
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
    public function destroy($id)
    {
        SalesOrder::destroy($id);
        return redirect()->back()->with('success', "Order Transaction successfully deleted. ");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use App\Mail\InvoiceEmail;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            //TODO: DISPLAY ONY THE USER AND TRANSACTION NUMBER FOR ORDER THEN ADD VIEW ORDER DETAILS BUTTON OR COLLAPSE EXPAND BOOTSTRAP THE DETAILS
            //       AND TRY TO CREATE THIS MYSQL QUERY INTO LARAVEL EQUIVALENT
            // SELECT * FROM users RIGHT JOIN sales_order ON sales_order.user_id = users.id WHERE EXISTS ( SELECT * FROM customers WHERE customers.user_id=users.id );
            $query = SalesOrder::query()
                        ->rightJoin('payments', 'payments.sales_order_id', '=', 'sales_order.id')
                        ->rightJoin('products', 'products.id', '=', 'sales_order.product_id')
                        ->rightJoin('categories', 'categories.id', '=', 'products.category_id')
                        ->rightJoin('users', 'users.id', '=', 'sales_order.user_id')
                        ->rightJoin('customers', 'customers.user_id', '=', 'users.id')
                        ->select(
                            'sales_order.id AS order_id',
                            'customers.user_id AS customers_user_id',
                            'categories.id AS categories_id',
                            'sales_order.user_id AS sales_order_user_id',
                            'sales_order.quantity AS order_quantity',
                            'customers.name',
                            'payments.*',
                            'sales_order.*',
                            'products.*',
                            'categories.*',
                        )
                        ->where('so_status', '=', 'preparing')
                        ->orderBy('sales_order.sales_date')
                        ->orderBy('sales_order.user_id');
            if(!empty($keyword)) {
                $query->where(function ($query) use ($keyword) {
                    $query->orWhere('transaction_number', 'LIKE', "%$keyword%")
                            ->orWhere('sales_order.quantity', 'LIKE', "%$keyword%")
                            ->orWhere('sales_order.sales_date', 'LIKE', "%$keyword%")
                            ->orWhere('total_amount', 'LIKE', "%$keyword%")
                            ->orWhere('price', 'LIKE', "%$keyword%")
                            ->orWhere('payments.status', 'LIKE', "%$keyword%");
                });
            }
            $orders = $query->fastPaginate($perPage);
            $orders_count = $query->count();
        }
        return view('dashboard.orders.index', compact('orders_count', 'orders'));
    }

    /**
     * Show Orders for each User
     */
    public function create($id)
    {
        $orders = SalesOrder::query()
                    ->leftJoin('payments', 'payments.sales_order_id', '=', 'sales_order.id')
                    ->leftJoin('products', 'products.id', '=', 'sales_order.product_id')
                    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                    ->leftJoin('users', 'users.id', '=', 'sales_order.user_id')
                    ->leftJoin('customers', 'customers.user_id', '=', 'users.id')
                    ->select(
                        'sales_order.id AS order_id',
                        'customers.user_id AS customers_user_id',
                        'categories.id AS categories_id',
                        'sales_order.user_id AS sales_order_user_id',
                        'sales_order.quantity AS order_quantity',
                        'customers.*',
                        'payments.*',
                        'sales_order.*',
                        'products.*',
                        'categories.*',
                        'users.email',
                    )
                    ->where('sales_order.user_id', '=', $id)
                    ->where('sales_order.so_status', '=', 'preparing')
                    ->orderBy('sales_order.sales_date')
                    ->orderBy('sales_order.user_id')
                    ->latest('sales_order.sales_date')->get();
        return view('dashboard.orders.show', compact('orders'));
    }

    /**
     * Complete all orders
     */
    public function store(Request $request)
    {
        // Assuming $request is the request object containing your data
        $data = $request->all();
        $prefix = auth()->user()->id;
        $invoice_number = $prefix . substr(md5(uniqid()), 0, 8);
        $user_id = '';
        $order_id = '';
        // dd($data);
        $orderIds = $data['order_id'];
        foreach ($orderIds as $index => $orderId) {
            $order = SalesOrder::findOrFail($orderId);
            $payment = Payment::query()->where('sales_order_id', '=', $orderId)->first();

            $user_id = $order->user_id;
            $order_id = $order->id;

            // // Update Sales
            // $order->so_status = 'complete';
            // $order->save();

            // // Update Payments
            // $payment->sales_invoice_number = $invoice_number;
            // $payment->paid_amount = $payment->sales_total_amount;
            // $payment->status = 'paid';
            // $payment->save();

            // // Update Inventory
            // $product = Product::query()->where('products.id', '=', $order->product_id)->first();
            // $product->quantity -= $order->quantity;
            // $product->save();
        }
        $user = User::query()
                    ->leftJoin('customers', 'customers.user_id', '=', 'users.id')
                    ->where('users.id', '=', $user_id)->first();
        $orders = SalesOrder::findOrFail($orderId)
                    ->leftJoin('payments', 'payments.sales_order_id', '=', 'sales_order.id')
                    ->leftJoin('products', 'products.id', '=', 'sales_order.product_id')
                    ->leftJoin('customers', 'customers.user_id', '=', 'sales_order.user_id')
                    ->select(
                        'sales_order.id AS order_id',
                        'customers.user_id AS customers_user_id',
                        'sales_order.user_id AS sales_order_user_id',
                        'sales_order.quantity AS order_quantity',
                        'customers.*',
                        'payments.*',
                        'sales_order.*',
                        'products.*',
                    )
                    ->whereIn('sales_order.id', $orderIds)  // Use whereIn to filter based on order IDs
                    ->where('sales_order.user_id', '=', $user_id)
                    ->get();
        // dd($orders);
        // Send the email
        Mail::to($user->email, $user->name)->send(new InvoiceEmail($orders));
        return redirect()->route('admin.orders')->with(['success' => 'Orders Successfully Completed.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        // Retrieve the status from the request
        $status = $request->input('status');
        $payment = Payment::query()->where('sales_order_id', '=', $id)->first();
        $payment->status = $status;
        $payment->save();
        // Return a response if necessary
        return response()->json(['success' => 'Status updated successfully ']);
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        // Retrieve the status from the request
        $input = $request->input('paymentMethod');
        $payment = Payment::query()->where('sales_order_id', '=', $id)->first();
        $payment->payment_method = $input;
        $payment->save();
        // Return a response if necessary
        return response()->json(['success' => 'Status updated successfully ']);
    }

    public function updatePaymentNote(Request $request, $id)
    {
        // Retrieve the status from the request
        $input = $request->input('paymentNote');
        $payment = Payment::query()->where('sales_order_id', '=', $id)->first();
        $payment->note = $input;
        $payment->save();
        // Return a response if necessary
        return response()->json(['success' => 'Payment Note updated successfully ']);
    }

    public function updatePaidAmount(Request $request, $id)
    {
        // Retrieve the status from the request
        $input = $request->input('paidAmount');
        $payment = Payment::query()->where('sales_order_id', '=', $id)->first();
        $payment->paid_amount = $input;
        $payment->save();
        // Return a response if necessary
        return response()->json(['success' => 'Payment Note updated successfully ']);
    }

    public function updateQuantity(Request $request, $id)
    {
        // Retrieve the status from the request
        $input = $request->input('qty');
        $order = SalesOrder::findOrFail($id);
        $payment = Payment::query()->where('sales_order_id', '=', $id)->first();

        $order->quantity = intval($input);
        $order->total_amount = $order->quantity * $order->price;
        $order->net_total = $order->quantity * $order->price;
        $order->save();

        $payment->sales_total_amount = $order->total_amount;
        $payment->save();
        // Return a response if necessary
        return response()->json(['success' => 'Quantity updated successfully ']);
    }

    public function updateSugarContent(Request $request, $id)
    {
        // Retrieve the status from the request
        $input = $request->input('sugarContent');
        $order = SalesOrder::findOrFail($id);
        $order->sugar_content = intval($input);
        $order->save();
        // Return a response if necessary
        return response()->json(['success' => 'Sugar Content updated successfully ']);
    }

    public function updateWriting(Request $request, $id)
    {
        // Retrieve the status from the request
        $input = $request->input('writing');
        $order = SalesOrder::findOrFail($id);
        $order->writing = $input;
        $order->save();
        // Return a response if necessary
        return response()->json(['success' => 'Writing updated successfully ']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = SalesOrder::findOrFail($id);
        $order->so_status = 'cancel';
        $order->save();
        $payment = Payment::query()->where('sales_order_id', '=', $id)->first();
        $payment_id = $payment->id;
        $payment->destroy($payment_id);
        return redirect()->back()->with('success', "Order Transaction successfully Cancelled! ");
    }
}

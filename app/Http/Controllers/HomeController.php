<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(auth()) {
            $id = auth()->id();
            $customer = Customer::where('user_id', $id)->first();
            $cashier = Cashier::where('user_id', $id)->first();
            if($customer && blank($customer->name)) {
                return redirect()->route('customer.profile');
            }
            if($cashier && blank($cashier->name)) {
                return redirect()->route('cashier.profile');
            }
        }
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $products = Product::query()
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                            ->select(
                                'products.id as product_id',
                                'product_name',
                                'description',
                                'category_name',
                                'company',
                                'contact_name',
                                'code',
                                'variant',
                                'image',
                                'quantity',
                                'unit_cost',
                                'total_cost',
                                'unit_price',
                                'expiry',
                            )
                            ->where('product_name', 'LIKE', "%$keyword%")
                            ->orWhere('code', 'LIKE', "%$keyword%")
                            ->orWhere('products.id', 'LIKE', "%$keyword%")
                            ->orWhere('category_name', 'LIKE', "%$keyword%")
                            ->orWhere('company', 'LIKE', "%$keyword%")
                            ->orWhere('total_amount', 'LIKE', "%$keyword%")
                            ->orWhere('unit_cost', 'LIKE', "%$keyword%")
                            ->orWhere('quantity', 'LIKE', "%$keyword%")
                            ->orWhere('total_cost', 'LIKE', "%$keyword%")
                            ->orWhere('unit_price', 'LIKE', "%$keyword%")
                            ->latest('products.created_at')->fastPaginate($perPage);
        } else {
            $products = Product::query()
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                            ->select(
                                'products.id as product_id',
                                'product_name',
                                'description',
                                'category_name',
                                'company',
                                'contact_name',
                                'code',
                                'variant',
                                'image',
                                'quantity',
                                'unit_cost',
                                'total_cost',
                                'unit_price',
                                'expiry',
                            )
                            ->latest('products.created_at')
                            ->fastPaginate($perPage);
        }
        return view('home', compact('products'));
    }

    public function addTray()
    {
        if(auth()->hasUser() == false) {
            return redirect()->back()->with('info', 'Need to Login your Account to continue Shopping. Login now?');
        }
    }

    public function viewProducts(Request $request)
    {
        // if(auth()) {
        //     $id = auth()->id();
        //     $customer = Customer::where('user_id', $id)->first();
        //     $cashier = Cashier::where('user_id', $id)->first();
        //     if($customer && blank($customer->name)) {
        //         return redirect()->route('customer.profile');
        //     }
        //     if($cashier && blank($cashier->name)) {
        //         return redirect()->route('cashier.profile');
        //     }
        // }
        // TODO: Get categories, suppliers and other necessary info to filtering products
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $products = Product::query()
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                            ->select(
                                'products.id as product_id',
                                'product_name',
                                'description',
                                'category_name',
                                'company',
                                'contact_name',
                                'code',
                                'variant',
                                'image',
                                'quantity',
                                'unit_cost',
                                'total_cost',
                                'unit_price',
                                'expiry',
                            )
                            ->where('product_name', 'LIKE', "%$keyword%")
                            ->orWhere('code', 'LIKE', "%$keyword%")
                            ->orWhere('products.id', 'LIKE', "%$keyword%")
                            ->orWhere('category_name', 'LIKE', "%$keyword%")
                            ->orWhere('company', 'LIKE', "%$keyword%")
                            ->orWhere('total_amount', 'LIKE', "%$keyword%")
                            ->orWhere('unit_cost', 'LIKE', "%$keyword%")
                            ->orWhere('quantity', 'LIKE', "%$keyword%")
                            ->orWhere('total_cost', 'LIKE', "%$keyword%")
                            ->orWhere('unit_price', 'LIKE', "%$keyword%")
                            ->latest('products.created_at')->fastPaginate($perPage);
        } else {
            $products = Product::query()
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
                            ->select(
                                'products.id as product_id',
                                'product_name',
                                'description',
                                'category_name',
                                'company',
                                'contact_name',
                                'code',
                                'variant',
                                'image',
                                'quantity',
                                'unit_cost',
                                'total_cost',
                                'unit_price',
                                'expiry',
                            )
                            ->latest('products.created_at')
                            ->fastPaginate($perPage);
        }
        return view('storefront.index', compact('products'));
    }
}

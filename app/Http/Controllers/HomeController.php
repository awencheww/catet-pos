<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Tray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    //Home page view
    public function index(Request $request)
    {
        if(auth()->user()) {
            $id = auth()->user()->id;
            $customer = Customer::where('user_id', $id)->first();
            $cashier = Cashier::where('user_id', $id)->first();
            if($customer && (blank($customer->name) || blank($customer->address) || blank($customer->phone_number))) {
                return redirect()->route('customer.profile');
            }
            if($cashier && (blank($cashier->name) || blank($cashier->address) || blank($cashier->phone_number))) {
                return redirect()->route('cashier.profile');
            }
            //add tray count
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
                    ->where('user_id', '=', $id)->get();
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
        if(auth()->user()) {
            return view('home', compact('products', 'tray_count', 'tray'));
        }
        return view('home', compact('products'));
    }

    //Storefront view
    public function viewProducts(Request $request)
    {
        if(auth()->user()) {
            $id = auth()->user()->id;
            $customer = Customer::where('user_id', $id)->first();
            $cashier = Cashier::where('user_id', $id)->first();
            if($customer && (blank($customer->name) || blank($customer->address) || blank($customer->phone_number))) {
                return redirect()->route('customer.profile');
            }
            if($cashier && (blank($cashier->name) || blank($cashier->address) || blank($cashier->phone_number))) {
                return redirect()->route('cashier.profile');
            }
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
                    ->where('user_id', '=', $id)->get();
        }
        $categories = Category::query()->get();
        $suppliers = Supplier::query()->get();
        // TODO: Get categories, suppliers and other necessary info to filtering products
        $keyword = $request->get('search');
        $perPage = 50;
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
        if(auth()->user()) {
            return view('storefront.index', compact('products', 'categories', 'suppliers', 'tray_count', 'tray'));
        }
        return view('storefront.index', compact('products', 'categories', 'suppliers'));
    }

    public function addTray(Request $request)
    {
        if(!auth()->user()) {
            return redirect()->back()->with('info', 'Need to Login your Account to continue Shopping. Login now?');
        } else {
            $user_id = auth()->user()->id;
            $product_id = $request->product_id;
        }
        $tray = Tray::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();
        if($tray) {
            return redirect()->back()->with('success', 'Already exist in your Tray!');
        }
        Tray::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ]);
        return redirect()->back()->with('success', 'Added to your tray'.$tray);
    }
}

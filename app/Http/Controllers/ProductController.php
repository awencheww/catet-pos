<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Buglinjo\LaravelWebp\Webp;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->get();
        $suppliers = Supplier::query()->get();
        // Detect the needed input fields from the model
        $fields = (new Product())->getFillable();

        return view('dashboard.products.create', compact('fields', 'categories', 'suppliers'));
    }

    public function saveImage($file)
    {
        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //Convert to webp
        $webp = Webp::make($file);
        // create directory public/images if not exist
        if (!File::exists(public_path('images/'))) {
            File::makeDirectory(public_path('images/'));
        }
        $webp->save(public_path('images/'.$file_name.'.webp'));
        return $file_name.'.webp';
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request using the detected input fields
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,webp|max:2028',
            'product_name' => 'required|string',
            'description' => '',
            'code' => '',
            'category_id' => '',
            'supplier_id' => '',
            'variant' => '',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required',
            'total_cost' => 'required',
            'unit_price' => 'required',
            'expiry' => 'required'
        ]);
        // Capitalize the first letter of the 'name' attribute
        $validatedData['product_name'] = ucwords($validatedData['product_name']);
        $validatedData['description'] = ucwords($validatedData['description']);
        $validatedData['code'] = strtoupper($validatedData['code']);
        $validatedData['variant'] = ucwords($validatedData['variant']);
        $validatedData['total_cost'] = $validatedData['quantity'] * $validatedData['unit_cost'];
        // image file save and convert to .webp
        if($request->image != null) {
            $validatedData['image'] = $this->saveImage($request->image);
        }
        // Create a new category using the validated data
        Product::create($validatedData);
        return redirect()->back()->with("success", "Product Added Successfully! ");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::query()->get();
        $suppliers = Supplier::query()->get();
        $fields = $product->getFillable();
        return view('dashboard.products.edit', compact('fields', 'product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validate the request using the detected input fields
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg,gif,webp|max:2028',
            'product_name' => 'required|string',
            'description' => '',
            'code' => '',
            'category_id' => '',
            'supplier_id' => '',
            'variant' => '',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required',
            'total_cost' => 'required',
            'unit_price' => 'required',
            'expiry' => 'required'
        ]);
        // Capitalize the first letter of the 'name' attribute
        $validatedData['product_name'] = ucwords($validatedData['product_name']);
        $validatedData['description'] = ucwords($validatedData['description']);
        $validatedData['code'] = strtoupper($validatedData['code']);
        $validatedData['variant'] = ucwords($validatedData['variant']);
        $validatedData['total_cost'] = $validatedData['quantity'] * $validatedData['unit_cost'];
        // image file save and convert to .webp
        if($request->image != null) {
            $validatedData['image'] = $this->saveImage($request->image);
        }

        // Create a new category using the validated data
        $product->update($validatedData);
        return redirect()->back()->with("success", "Supplier Updated Successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', "Product successfully deleted. ");
    }

}

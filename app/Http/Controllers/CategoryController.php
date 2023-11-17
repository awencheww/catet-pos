<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;
        if($keyword !== null) {
            $categories = Category::query()
                            ->where('name', 'LIKE', "%$keyword%")
                            ->latest('created_at')->fastPaginate($perPage);
        } else {
            $categories = Category::query()->latest('created_at')
                            ->fastPaginate($perPage);
        }
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Detect the needed input fields from the model
        $fields = (new Category())->getFillable();

        return view('dashboard.categories.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request using the detected input fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // Capitalize the first letter of the 'name' attribute
        $validatedData['name'] = ucwords($validatedData['name']);
        // Create a new category using the validated data
        Category::create($validatedData);
        return redirect()->back()->with("success", "Category Added Successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $fields = $category->getFillable();
        return view('dashboard.categories.edit', compact('fields', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $validatedData['name'] = ucwords($validatedData['name']);
        $category->update($validatedData);
        return redirect()->back()->with("success", "Category Updated Successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        abort_unless(Auth::user()->role === 'admin', 403);
        Category::destroy($category->id);
        return redirect()->back()->with('success', "Category successfully deleted.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = DB::table('products')->get();
        $categories = DB::table('categories')->get();
        
        return view('products.index', ['products' => $products, 'categories' => $categories]);
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_code' => 'required|min:3|max:100|string|unique:products,product_code',
           'name' => 'required|min:3|max:100|string', 
           'description' => 'min:3|max:500|nullable|string',
           'stock' => 'required|min:0|integer',
           'price' => 'required|numeric|min:0',
           'category_id' => 'required|exists:categories,id',
           'active' => 'required|boolean',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $validated = $request->validate([
            'product_code' => [
                'required',
                'min:3',
                'max:100',
                'string',
                Rule::unique('products', 'product_code')->ignore($product),
            ],
           'name' => 'required|min:3|max:100|string', 
           'description' => 'min:3|max:500|nullable|string',
           'stock' => 'required|min:0|integer',
           'price' => 'required|numeric|min:0',
           'category_id' => 'required|exists:categories,id',
           'active' => 'required|boolean',
        ]);

        
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'product successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product successfully deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all(); 

        // Pass the products to the view
        return view('app.products.index', compact('products'));
    }

    public function create()
    {
        return view('app.products.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cow,buffalo',
        ]);

        // Create and save the product
        Product::create([
            'name' => $request->name,
            'type' => $request->type, 
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('app.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:cow,buffalo',
        ]);

        // Find the product and update it
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'type' => $request->type, 
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        // Find the product and delete it
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}

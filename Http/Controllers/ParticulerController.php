<?php

namespace App\Http\Controllers;

use App\Models\Particuler;
use Illuminate\Http\Request;

class ParticulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $particulers = Particuler::all();
        return view('app.stock-products.index', compact('particulers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Particuler::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Product added.');
    }

    public function update(Request $request, Particuler $particuler)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $particuler->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Product updated.');
    }

    public function destroy($id)
    {
        // Delete all related stocks first
        Particuler::findOrFail($id)->delete();
    
        return redirect()->back()->with('success', 'Product deleted.');
    }
    
}

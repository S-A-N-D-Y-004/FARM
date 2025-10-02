<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnMilk;
use App\Models\Product;
use App\Models\ReturnMilkEntry;
use Illuminate\Support\Facades\DB;


class ReturnMilkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $returnMilks = ReturnMilk::with('entries')->get();
        // $returnMilks = ReturnMilk::with('entries.product')->latest()->get();
        $returnMilks = ReturnMilk::with('entries.product')->latest()->paginate(10);
        // $returns = ReturnMilk::with('entries.product')->latest()->get();
        $totals = [];

        foreach ($returnMilks as $return) {
            foreach ($return->entries as $entry) {
                $totals[$entry->product_id] = ($totals[$entry->product_id] ?? 0) + $entry->quantity;
            }
        }
        return view('app.return-milk.index', compact( 'returnMilks', 'products', 'totals'));
    }

    public function create()
    {
         $existingDates = DB::table('return_milk')->pluck('date')->toArray();
        $products = Product::all();
        return view('app.return-milk.create', compact('products','existingDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $returnMilk = ReturnMilk::create([
            'date' => $request->date,
        ]);

        foreach ($request->products as $entry) {
            if (!empty($entry['product_id']) && !empty($entry['quantity'])) {
                ReturnMilkEntry::create([
                    'return_milk_id' => $returnMilk->id,
                    'product_id' => $entry['product_id'],
                    'quantity' => $entry['quantity'],
                ]);
            }
        }
        $entries = ReturnMilkEntry::with('product')
            ->where('return_milk_id', $returnMilk->id)
            ->get();

        $returnMilk->calculateAndSetTotals($entries);
        $returnMilk->save();


        return redirect()->route('return-milk.index')->with('success', 'Return milk recorded successfully.');
    }

    public function edit(ReturnMilk $returnMilk)
    {
        $products = Product::all();
        $returnMilk->load('entries');
        return view('app.return-milk.edit', compact('returnMilk', 'products'));
    }

    public function update(Request $request, ReturnMilk $returnMilk)
    {
        $request->validate([
            'date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:0.01',
        ]);

        // Update the main return_milk record
        $returnMilk->update([
            'date' => $request->date,
        ]);

        // Delete old entries
        $returnMilk->entries()->delete();

        // Recreate entries from the form

        foreach ($request->products as $entry) {
            ReturnMilkEntry::create([
                'return_milk_id' => $returnMilk->id,
                'product_id' => $entry['product_id'],
                'quantity' => $entry['quantity'],
            ]);
        }
        $entries = ReturnMilkEntry::with('product')
            ->where('return_milk_id', $returnMilk->id)
            ->get();

        $returnMilk->calculateAndSetTotals($entries);
        $returnMilk->save();


        return redirect()->route('return-milk.index')->with('success', 'Return milk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $returnMilk = ReturnMilk::findOrFail($id);
        $returnMilk->delete();

        return redirect()->route('return-milk.index')->with('success', 'Return milk deleted successfully.');
    }
}

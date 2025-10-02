<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Particuler;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('particuler')->orderBy('date', 'desc')->get();
        $particulers = Particuler::all();
        return view('app.stocks.index', compact('stocks', 'particulers'));
    }

    public function createMultiple()
    {
        $products = Particuler::all();
        $firstEntryProducts = Particuler::whereDoesntHave('stocks')->pluck('id')->toArray();
                return view('app.stocks.create-multiple', compact('products','firstEntryProducts'));
    }

    public function storeMultiple(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'stocks.*.product_id' => 'required|exists:particulers,id',
            'stocks.*.used_quantity' => 'required|numeric|min:0',
            'stocks.*.added_quantity' => 'required|numeric|min:0',
            'stocks.*.remaining_stock' => 'nullable|numeric|min:0',
        ]);
    
        $date = $request->input('date');
        $entries = $request->input('stocks');
    
      foreach ($entries as $entry) {
    // Skip if duplicate entry exists for same date + product
    $exists = Stock::where('date', $date)
        ->where('particuler_id', $entry['product_id'])
        ->exists();

    if ($exists) continue;

    $productId = $entry['product_id'];

    // Calculate remaining stock
    $previousStock = Stock::where('particuler_id', $productId)
        ->where('date', '<', $date)
        ->orderBy('date', 'desc')
        ->first();

    $previousRemaining = $previousStock ? $previousStock->remaining_stock : 0;

    // Apply same formula for both first and subsequent entries
    $remainingStock = $previousRemaining + $entry['added_quantity'] - $entry['used_quantity'];

    // Save to DB
    Stock::create([
        'date' => $date,
        'particuler_id' => $productId,
        'used_quantity' => $entry['used_quantity'],
        'added_quantity' => $entry['added_quantity'],
        'remaining_stock' => $remainingStock,
    ]);
}

    
        return redirect()->route('stock-products.index')->with('success', 'Stocks saved successfully.');
    }
    
    
    public function viewByParticuler($particulerId)
    {
        $particuler = \App\Models\Particuler::findOrFail($particulerId);
        $stocks = \App\Models\Stock::where('particuler_id', $particulerId)->orderBy('date', 'desc')->get();

        $stocks = \App\Models\Stock::where('particuler_id', $particulerId)->orderBy('date', 'desc')->latest()->paginate(10);


        return view('app.stocks.view-by-particuler', compact('particuler', 'stocks'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'used_quantity' => 'required|numeric',
            'added_quantity' => 'required|numeric',
        ]);
    
        $stock = \App\Models\Stock::findOrFail($id);
    
       $previousStock = \App\Models\Stock::where('particuler_id', $stock->particuler_id)
    ->where('date', '<', $request->date)
    ->orderBy('date', 'desc')
    ->first();

$previousRemaining = $previousStock ? $previousStock->remaining_stock : 0;

$remainingStock = $previousRemaining + $request->added_quantity - $request->used_quantity;

$stock->update([
    'date' => $request->date,
    'used_quantity' => $request->used_quantity,
    'added_quantity' => $request->added_quantity,
    'remaining_stock' => $remainingStock,
]);

    
        return redirect()->back()->with('success', 'Stock entry updated.');
    }
    

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->back()->with('success', 'Stock entry deleted.');
    }
}

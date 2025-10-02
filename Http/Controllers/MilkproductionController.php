<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilkproductionUpdateRequest;
use App\Http\Requests\MilkproductionStoreRequest;
use App\Models\Milkproduction;
use App\Models\Product;
use App\Models\MilkProductionEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class MilkproductionController extends Controller
{
    public function index()
    {
        $milkProductions = MilkProduction::with('entries.product')->get();
        $milkProductions = MilkProduction::orderBy('date', 'desc')->paginate(10);
   
        $products = Product::all();

        // Optionally calculate totals
        foreach ($milkProductions as $production) {
            $production->total_cow_milk = 0;
            $production->total_buffalo_milk = 0;

            foreach ($production->entries as $entry) {
                if ($entry->product && $entry->product->type === 'cow') {
                    $production->total_cow_milk += $entry->quantity;
                } elseif ($entry->product && $entry->product->type === 'buffalo') {
                    $production->total_buffalo_milk += $entry->quantity;
                }
            }
        }
        $totals = [];
        $cowMilkTotal = 0;
        $buffaloMilkTotal = 0;

        foreach ($products as $product) {
            $totals[$product->id] = 0;
        }

        foreach ($milkProductions as $production) {
            foreach ($production->entries as $entry) {
                $totals[$entry->product_id] += $entry->quantity;

                if ($entry->product->type === 'cow') {
                    $cowMilkTotal += $entry->quantity;
                } elseif ($entry->product->type === 'buffalo') {
                    $buffaloMilkTotal += $entry->quantity;
                }
            }
        }
        return view('app.milk-production.index', compact('milkProductions', 'products', 'totals', 'cowMilkTotal', 'buffaloMilkTotal'));
    }

    public function create(MilkProduction $milkProduction)
    {
        $existingDates = DB::table('milk_production')->pluck('date')->toArray();
        // $milkProduction = MilkProduction::all();
        $milkProduction->load('entries');
        $products = Product::all();
        return view('app.milk-production.create', compact('products', 'milkProduction','existingDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'quantities' => 'required|array',
        ]);
    
        $milkProduction = MilkProduction::create([
            'date' => $request->date,
        ]);
    
        foreach ($request->quantities as $productId => $quantity) {
            if ($quantity !== null) {
                MilkProductionEntry::create([
                    'milk_production_id' => $milkProduction->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }
    
      
        $entries = MilkProductionEntry::with('product')
            ->where('milk_production_id', $milkProduction->id)
            ->get();
    
        $milkProduction->calculateAndSetTotals($entries);
        $milkProduction->save();
    
        return redirect()->route('milk-production.index')->with('success', 'Milk Production record added!');
    }
    

    public function show()
    {
        return view('app.milk-production.show', compact('milkProduction'));
    }

    public function edit(MilkProduction $milkProduction)
    {

        $milkProduction->load('entries');
        $products = Product::all();
        return view('app.milk-production.edit', compact('milkProduction', 'products'));
    }
    public function update(Request $request, MilkProduction $milkProduction)
    {
        $request->validate([
            'date' => 'required|date',
            'quantities' => 'required|array',
        ]);
    
        // Update the date field
        $milkProduction->update([
            'date' => $request->date,
        ]);
    
        // Delete old entries
        MilkProductionEntry::where('milk_production_id', $milkProduction->id)->delete();
    
        // Add new entries
        foreach ($request->quantities as $productId => $quantity) {
            if ($quantity !== null) {
                MilkProductionEntry::create([
                    'milk_production_id' => $milkProduction->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }
    
        // Reload entries with product relation
        $entries = MilkProductionEntry::with('product')
            ->where('milk_production_id', $milkProduction->id)
            ->get();
    
        // Calculate and update totals
        $milkProduction->calculateAndSetTotals($entries);
        $milkProduction->save();
    
        return redirect()->route('milk-production.index')->with('success', 'Milk Production record updated!');
    }
    


    public function destroy(MilkProduction $milkProduction)
    {
        $milkProduction->delete();
        return redirect()->route('milk-production.index')->with('success', 'Milk Production record deleted successfully!');
    }
}

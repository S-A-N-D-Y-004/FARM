<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Yogurt;
use App\Models\YogurtDispatch;
use Illuminate\Support\Facades\DB;


class YogurtController extends Controller
{
    public function index(){
        $yogurts = Yogurt::all();
        return view('app.yogurt.index', compact('yogurts'));
    }

    public function create(){
        $existingDates = DB::table('yogurt')->pluck('date')->toArray();
        return view('app.yogurt.create', compact('existingDates'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'date' => 'required|date',
            'fat_content' => 'required|numeric',
            'buffalo_milk' => 'required|numeric',
            'cow_milk' => 'required|numeric',
            'one_kg' => 'required|numeric',
            'five_kg' => 'required|numeric',
            'ten_kg' => 'required|numeric',
        ]);
        $validated['total_kg'] = $validated['one_kg'] * 1 + $validated['five_kg'] * 5 + $validated['ten_kg'] * 10;
        Yogurt::create($validated);
        return redirect()->route('yogurt.index')->with('success', 'Yogurt record created successfully.');
    }
    public function edit($id){
        $yogurt = Yogurt::findOrFail($id);
        return view('app.yogurt.edit', compact('yogurt'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
             'date' => 'required|date',
            'fat_content' => 'required|numeric',
            'buffalo_milk' => 'required|numeric',
            'cow_milk' => 'required|numeric',
            'one_kg' => 'required|numeric',
            'five_kg' => 'required|numeric',
            'ten_kg' => 'required|numeric',
        ]);
        $validated['total_kg'] = $validated['one_kg'] * 1 + $validated['five_kg'] * 5 + $validated['ten_kg'] * 10;
        
        $yogurt = Yogurt::findOrFail($id);
        $yogurt->update($validated);
        return redirect()->route('yogurt.index')->with('success', 'Yogurt record updated successfully.');
    }
    public function destroy($id){
        $yogurt = Yogurt::findOrFail($id);
        $yogurt->delete();
        return redirect()->route('yogurt.index')->with('success', 'Yogurt record deleted successfully.');
    }
    public function closingStock($id)
    {
        $yogurt = Yogurt::findOrFail($id);

        $dispatch = DB::table('yogurt_dispatch')
            ->where('yogurt_id', $id)
            ->selectRaw('
                COALESCE(SUM(one_kg),0) as dispatched_one_kg,
                COALESCE(SUM(five_kg),0) as dispatched_five_kg,
                COALESCE(SUM(ten_kg),0) as dispatched_ten_kg
            ')
            ->first();

        $remaining_one_kg = $yogurt->one_kg - $dispatch->dispatched_one_kg;
        $remaining_five_kg = $yogurt->five_kg - $dispatch->dispatched_five_kg;
        $remaining_ten_kg = $yogurt->ten_kg - $dispatch->dispatched_ten_kg;
        $total_remaining_kg = $remaining_one_kg * 1 + $remaining_five_kg * 5 + $remaining_ten_kg * 10;

        return view('app.yogurt.closing_stock', compact(
            'yogurt',
            'remaining_one_kg',
            'remaining_five_kg',
            'remaining_ten_kg',
            'total_remaining_kg'
        ));
    }
}

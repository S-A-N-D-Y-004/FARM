<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkHandlingLoss;
use Illuminate\Support\Facades\DB;

class MilkHandlingLossController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $records = MilkHandlingLoss::orderBy('date', 'desc')->get();
        return view('app.milk-handling-loss.index', compact('records'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $existingDates = DB::table('milk_handling_loss')->pluck('date')->toArray();
        return view('app.milk-handling-loss.create', compact('existingDates'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'buffalo_milk' => 'required|numeric',
            'cow_milk' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);
        MilkHandlingLoss::create($validated);
        return redirect()->route('milk-handling-loss.index')->with('success', 'Record added successfully.');
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $record = MilkHandlingLoss::findOrFail($id);
        return view('app.milk-handling-loss.edit', compact('record'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'buffalo_milk' => 'required|numeric',
            'cow_milk' => 'required|numeric',
            'remarks' => 'nullable|string',
        ]);
        $record = MilkHandlingLoss::findOrFail($id);
        $record->update($validated);
        return redirect()->route('milk-handling-loss.index')->with('success', 'Record updated successfully.');
    }

    // Delete the specified resource from storage.
    public function destroy($id)
    {
        $record = MilkHandlingLoss::findOrFail($id);
        $record->delete();
        return redirect()->route('milk-handling-loss.index')->with('success', 'Record deleted successfully.');
    }
}

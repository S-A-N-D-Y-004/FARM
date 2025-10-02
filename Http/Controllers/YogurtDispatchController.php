<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\YogurtDispatch;
use Illuminate\Support\Facades\DB;

class YogurtDispatchController extends Controller
{
    public function index()
    {
        $yogurtDispatches = YogurtDispatch::all();
        
        return view('app.yogurt-dispatch.index', compact('yogurtDispatches'));
    }

    public function create()
    {
        $existingDates = DB::table('yogurt_dispatch')->pluck('date')->toArray();
        return view('app.yogurt-dispatch.create', compact('existingDates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'one_kg' => 'required|numeric',
            'five_kg' => 'required|numeric',
            'ten_kg' => 'required|numeric',
        ]);
        $validated['total_kg'] = $validated['one_kg'] * 1 + $validated['five_kg'] * 5 + $validated['ten_kg'] * 10;

        YogurtDispatch::create($validated);
        return redirect()->route('yogurt-dispatch.index')->with('success', 'Yogurt dispatch record created successfully.');
    }

    public function edit($id)
    {
        $yogurtDispatch = YogurtDispatch::findOrFail($id);
        return view('app.yogurt-dispatch.edit', compact('yogurtDispatch'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'one_kg' => 'required|numeric',
            'five_kg' => 'required|numeric',
            'ten_kg' => 'required|numeric',
        ]);
        $validated['total_kg'] = $validated['one_kg'] * 1 + $validated['five_kg'] * 5 + $validated['ten_kg'] * 10;

        $yogurtDispatch = YogurtDispatch::findOrFail($id);
        $yogurtDispatch->update($validated);
        return redirect()->route('yogurt-dispatch.index')->with('success', 'Yogurt dispatch record updated successfully.');
    }

    public function destroy($id)
    {
        $yogurtDispatch = YogurtDispatch::findOrFail($id);
        $yogurtDispatch->delete();
        return redirect()->route('yogurt-dispatch.index')->with('success', 'Yogurt dispatch record deleted successfully.');
    }
}

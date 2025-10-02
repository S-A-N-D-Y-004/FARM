<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaneerProduction;
use App\Http\Requests\StorePaneerProductionRequest;
use App\Http\Requests\UpdatePaneerProductionRequest;
use Illuminate\Support\Facades\DB;

class PaneerProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $paneers = PaneerProduction::orderByDesc('date')
        ->paginate(10); // This returns a paginator instance

    $paneers->getCollection()->transform(function ($paneer) {
        $paneer->paneer_remaining_total =
            ($paneer->remaining_buffalo_paneer ?? 0) +
            ($paneer->remaining_cow_paneer ?? 0) +
            ($paneer->remaining_mixed_paneer ?? 0);
        return $paneer;
    });

    return view('app.paneer.index', compact('paneers')); 
}


       

    public function create()
    {
        $existingDates = DB::table('paneer_productions')->pluck('date')->toArray();
        return view('app.paneer.create', compact('existingDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'buffalo_milk' => 'nullable|numeric|min:0',
            'cow_milk' => 'nullable|numeric|min:0',
            'output_buffalo_paneer' => 'nullable|numeric|min:0',
            'output_cow_paneer' => 'nullable|numeric|min:0',
            'output_mixed_paneer' => 'nullable|numeric|min:0',
            'buffalo_milk_wastage' => 'nullable|numeric|min:0',
            'cow_milk_wastage' => 'nullable|numeric|min:0',
            'dispatch_buffalo_paneer' => 'nullable|numeric|min:0',
            'dispatch_cow_paneer' => 'nullable|numeric|min:0',
            'dispatch_mixed_paneer' => 'nullable|numeric|min:0',
            'remaining_buffalo_paneer' => 'nullable|numeric|min:0',
            'remaining_cow_paneer' => 'nullable|numeric|min:0',
            'remaining_mixed_paneer' => 'nullable|numeric|min:0',
        ]);

        // Check if the date already exists
        if (PaneerProduction::where('date', $request->date)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['date' => 'Entry for this date already exists.']);
        }

        PaneerProduction::create($request->all());

        return redirect()->route('paneer.index')->with('success', 'Paneer production entry created.');
    }

    public function edit(PaneerProduction $paneer)
    {
        return view('app.paneer.edit', compact('paneer'));
    }

    public function update(Request $request, PaneerProduction $paneer)
    {
        $request->validate([
            'date' => 'required|date',
            'buffalo_milk' => 'nullable|numeric|min:0',
            'cow_milk' => 'nullable|numeric|min:0',
            'output_buffalo_paneer' => 'nullable|numeric|min:0',
            'output_cow_paneer' => 'nullable|numeric|min:0',
            'output_mixed_paneer' => 'nullable|numeric|min:0',
            'buffalo_milk_wastage' => 'nullable|numeric|min:0',
            'cow_milk_wastage' => 'nullable|numeric|min:0',
            'dispatch_buffalo_paneer' => 'nullable|numeric|min:0',
            'dispatch_cow_paneer' => 'nullable|numeric|min:0',
            'dispatch_mixed_paneer' => 'nullable|numeric|min:0',
            'remaining_buffalo_paneer' => 'nullable|numeric|min:0',
            'remaining_cow_paneer' => 'nullable|numeric|min:0',
            'remaining_mixed_paneer' => 'nullable|numeric|min:0',
        ]);

        $paneer->update($request->all());

        return redirect()->route('paneer.index')->with('success', 'Paneer production updated successfully.');
    }

    public function destroy(PaneerProduction $paneer)
    {
        $paneer->delete();
        return redirect()->route('paneer.index')->with('success', 'Paneer production deleted.');
    }
}

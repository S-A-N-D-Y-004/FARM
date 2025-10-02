<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Culture;
use Illuminate\Support\Facades\DB;

class CultureController extends Controller
{
    public function index()
    {
        $cultures = Culture::orderBy('date', 'desc')->get();
        $cultures = Culture::latest()->paginate(10);

        return view('app.culture.index', compact('cultures'));
    }

    public function create()
    {
        return view('app.culture.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:cultures,date',
            'total_culture' => 'nullable|integer',
            'added_culture' => 'nullable|numeric',
            'remaining_stock' => 'nullable|integer',
        ]);

        // Fetch tm, stm, dtm from curdbatch for the selected date FIRST
        $curdbatch = DB::table('curdbatch')->where('date', $validated['date'])->first();

        if ($curdbatch) {
            $tm = $curdbatch->tm_culture ?? 0;
            $stm = $curdbatch->stm_culture ?? 0;
            $dtm = $curdbatch->dtm_culture ?? 0;

            // Calculate total_culture as tm + stm + dtm
            $validated['total_culture'] = $tm + $stm + $dtm;

            // Store tm, stm, dtm
            $validated['tm'] = $tm;
            $validated['stm'] = $stm;
            $validated['dtm'] = $dtm;
        } else {
            $validated['total_culture'] = 0;
        }

        // Check if this is the first entry
        $isFirstEntry = Culture::count() === 0;

        if ($isFirstEntry) {
            // For the first entry, allow manual input
            $validated['remaining_stock'] = $request->input('remaining_stock');
        } else {
            // Get the latest culture entry before this date
            $previousCulture = Culture::where('date', '<', $validated['date'])
                ->orderBy('date', 'desc')
                ->first();

            $addedCulture = $validated['added_culture'] ?? 0;
            $totalCulture = $validated['total_culture'] ?? 0;

            if ($previousCulture) {
                $previousRemaining = $previousCulture->remaining_stock ?? 0;
                $validated['remaining_stock'] = $previousRemaining + $addedCulture - $totalCulture;
            } else {
                // First record
                $validated['remaining_stock'] = $addedCulture - $totalCulture;
            }
        }

        Culture::create($validated);

        return redirect()->route('culture.index')->with('success', 'Culture record added.');
    }




    public function show(Culture $culture)
    {
        return view('app.culture.show', compact('culture'));
    }

    public function edit(Culture $culture)
    {
        return view('app.culture.edit', compact('culture'));
    }

    public function update(Request $request, Culture $culture)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:cultures,date,' . $culture->id,
            'added_culture' => 'nullable|numeric',
            'remaining_stock' => 'nullable|numeric',
        ]);

        // Fetch tm, stm, dtm
        $curdbatch = DB::table('curdbatch')->where('date', $validated['date'])->first();

        $tm = $curdbatch->tm_culture ?? 0;
        $stm = $curdbatch->stm_culture ?? 0;
        $dtm = $curdbatch->dtm_culture ?? 0;

        $totalCulture = $tm + $stm + $dtm;

        $validated['tm'] = $tm;
        $validated['stm'] = $stm;
        $validated['dtm'] = $dtm;
        $validated['total_culture'] = $totalCulture;

        // No need to override added_culture!

        // Calculate remaining stock
        $firstEntry = Culture::orderBy('date')->first();
        $isFirstEntry = $firstEntry && $firstEntry->id === $culture->id;

        if ($isFirstEntry) {
            $validated['remaining_stock'] = $validated['added_culture'] - $totalCulture;
        } else {
            $previousCulture = Culture::where('date', '<', $validated['date'])
                ->where('id', '!=', $culture->id)
                ->orderBy('date', 'desc')
                ->first();

            if ($previousCulture) {
                $previousRemaining = $previousCulture->remaining_stock ?? 0;
                $validated['remaining_stock'] = $previousRemaining + $validated['added_culture'] - $totalCulture;
            } else {
                $validated['remaining_stock'] = $validated['added_culture'] - $totalCulture;
            }
        }

        $culture->update($validated);

        return redirect()->route('culture.index')->with('success', 'Culture record updated.');
    }





    public function destroy(Culture $culture)
    {
        $culture->delete();
        return redirect()->route('culture.index')->with('success', 'Culture record deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Smp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isFirstEntry = Smp::count() === 0;
        $smps = Smp::orderBy('date', 'desc')->paginate(10); 

        return view('app.smp.index', compact('smps', 'isFirstEntry'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:smps,date',
            'total_smp' => 'nullable|integer',
            'milk' => 'nullable|integer',
            'added_smp' => 'nullable|integer',
            'remaining_stock' => 'nullable|integer',
        ]);

        // Fetch tm, stm, dtm from curdbatch for the selected date
        $curdbatch = DB::table('curdbatch')->where('date', $validated['date'])->first();

        if ($curdbatch) {
            $tm = $curdbatch->tm_skimmed_milk_provider ?? 0;
            $stm = $curdbatch->stm_skimmed_milk_provider ?? 0;
            $dtm = $curdbatch->dtm_skimmed_milk_provider ?? 0;

            $validated['total_smp'] = $tm + $stm + $dtm + ($validated['milk'] ?? 0);
            $validated['tm'] = $tm;
            $validated['stm'] = $stm;
            $validated['dtm'] = $dtm;
        }

        // Get the latest smp entry before this date
        $previousSmp = Smp::where('date', '<', $validated['date'])->orderBy('date', 'desc')->first();

        $addedSmp = $validated['added_smp'] ?? 0;
        $totalSmp = $validated['total_smp'] ?? 0;

        if ($previousSmp) {
            $previousRemaining = $previousSmp->remaining_stock ?? 0;
            $validated['remaining_stock'] = $previousRemaining + $addedSmp - $totalSmp;
        } else {
            $validated['remaining_stock'] = $addedSmp - $totalSmp;
        }

        Smp::create($validated);

        return redirect()->route('smp.index')->with('success', 'Smp record added.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'milk' => 'nullable|numeric',
            'added_smp' => 'nullable|numeric',
        ]);

        $smp = Smp::findOrFail($id);

        $curdbatch = DB::table('curdbatch')->where('date', $validated['date'])->first();

        if ($curdbatch) {
            $tm = $curdbatch->tm_skimmed_milk_provider ?? 0;
            $stm = $curdbatch->stm_skimmed_milk_provider ?? 0;
            $dtm = $curdbatch->dtm_skimmed_milk_provider ?? 0;

            $validated['total_smp'] = $tm + $stm + $dtm + ($validated['milk'] ?? 0);
            $validated['tm'] = $tm;
            $validated['stm'] = $stm;
            $validated['dtm'] = $dtm;
        } else {
            $validated['total_smp'] = 0;
            $validated['tm'] = 0;
            $validated['stm'] = 0;
            $validated['dtm'] = 0;
        }

        $previousSmp = Smp::where('date', '<', $validated['date'])->orderBy('date', 'desc')->first();

        $addedSmp = $validated['added_smp'] ?? 0;
        $totalSmp = $validated['total_smp'] ?? 0;

        if ($previousSmp) {
            $previousRemaining = $previousSmp->remaining_stock ?? 0;
            $validated['remaining_stock'] = $previousRemaining + $addedSmp - $totalSmp;
        } else {
            $validated['remaining_stock'] = $addedSmp - $totalSmp;
        }

        if (isset($validated['milk'])) {
            $smp->milk = $validated['milk'];
        }

        $smp->update($validated);

        return redirect()->route('smp.index')->with('success', 'SMP record updated.');
    }

    public function destroy(Smp $smp)
    {
        $smp->delete();
        return redirect()->back()->with('success', 'SMP record deleted.');
    }

    public function show(Smp $smp)
    {
        return view('smp.show', compact('smp'));
    }

    
}

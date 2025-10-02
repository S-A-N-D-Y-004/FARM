<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurdBatchStoreRequest;
use Illuminate\Http\Request;
use App\Models\Curdbatch;
use App\Models\CurdbatchName;
use App\Http\Requests\CurdBatchUpdateRequest;
use Illuminate\Support\Facades\DB;

class CurdbatchController extends Controller
{
    // public function index()
    // {
    //     $batchNames = CurdBatchName::all();
    //     $curdbatches = CurdBatch::orderBy('date', 'desc')->get();
    //     //  $curdbatches = Curdbatch::all();
    //   return view('app.curd-batch.index', compact('curdbatches','batchNames'));  
    // }


    public function index(Request $request)
    {
        $batchNames = CurdBatchName::all();

        $milkTypes = [
            'Tonned Milk' => 'tm_',
            'Double Tonned Milk' => 'dtm_',
            'Standard Tonned Milk' => 'stm_',
        ];

        $activeTab = $request->get('active_tab', 'tm_'); // Default to the first tab (Tonned Milk)

        $curdbatches = [];
        foreach ($milkTypes as $prefix) {
            $curdbatches[$prefix] = CurdBatch::whereNotNull($prefix . 'whole_buffalo_milk')
                ->orWhereNotNull($prefix . 'skimmed_buffalo_milk')
                ->orWhereNotNull($prefix . 'skimmed_cow_milk')
                ->orderBy('date', 'desc')
                ->paginate(10, ['*'], $prefix . '_page'); // Separate pagination for each tab
        }

        return view('app.curd-batch.index', compact('curdbatches', 'batchNames', 'milkTypes', 'activeTab'));
    }

    public function create()
    {
        $existingDates = DB::table('curdbatch')->pluck('date')->toArray();
        $batchNames = CurdBatchName::all();
        return view('app.curd-batch.create', compact('batchNames', 'existingDates'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            // 'name' => 'required|string|max:255',
            // TM fields
            'tm_whole_buffalo_milk' => 'nullable|numeric',
            'tm_skimmed_buffalo_milk' => 'nullable|numeric',
            'tm_total_buffalo_milk' => 'nullable|numeric',
            'tm_total_cow_milk' => 'nullable|numeric',
            'tm_skimmed_cow_milk' => 'nullable|numeric',
            'tm_skimmed_milk_provider' => 'nullable|numeric',
            'tm_one_kg' => 'nullable|numeric',
            'tm_five_kg' => 'nullable|numeric',
            'tm_ten_kg' => 'nullable|numeric',
            'tm_culture'    => 'nullable|numeric',

            // STM fields
            'stm_whole_buffalo_milk' => 'nullable|numeric',
            'stm_skimmed_buffalo_milk' => 'nullable|numeric',
            'stm_total_buffalo_milk' => 'nullable|numeric',
            'stm_total_cow_milk' => 'nullable|numeric',
            'stm_skimmed_cow_milk' => 'nullable|numeric',
            'stm_skimmed_milk_provider' => 'nullable|numeric',
            'stm_one_kg' => 'nullable|numeric',
            'stm_five_kg' => 'nullable|numeric',
            'stm_ten_kg' => 'nullable|numeric',
            'stm_culture'    => 'nullable|numeric',

            // DTM fields
            'dtm_whole_buffalo_milk' => 'nullable|numeric',
            'dtm_skimmed_buffalo_milk' => 'nullable|numeric',
            'dtm_total_buffalo_milk' => 'nullable|numeric',
            'dtm_total_cow_milk' => 'nullable|numeric',
            'dtm_skimmed_cow_milk' => 'nullable|numeric',
            'dtm_skimmed_milk_provider' => 'nullable|numeric',
            'dtm_one_kg' => 'nullable|numeric',
            'dtm_five_kg' => 'nullable|numeric',
            'dtm_ten_kg' => 'nullable|numeric',
            'dtm_culture'    => 'nullable|numeric',
        ]);

        $curdBatch = new \App\Models\Curdbatch();
        $curdBatch->fill($request->only($curdBatch->getFillable()));
        $curdBatch->save();

        return redirect()->route('curd-batch.index')->with('success', 'Curd Batch created successfully!');
    }


    // public function edit($date)
    // {
    //     // Fetch all CurdBatch records for the given date and group them by 'name' (e.g., tm, stm, dtm)
    //     $batches = \App\Models\CurdBatch::where('date', $date)->get()->keyBy('name');

    //     // Optional: If you use batch names in the form
    //     $batchNames = \App\Models\CurdBatchName::all();

    //     // Pass to view as curdBatch
    //     $curdbatch = $batches;

    //     return view('app.curd-batch.edit', compact('date', 'batchNames', 'curdbatch'));
    // }

    public function edit($id)
    {
        $curdbatch = CurdBatch::findOrFail($id); // Load the batch you want to edit
        return view('app.curd-batch.edit', compact('curdbatch'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',

            // TM fields
            'tm_whole_buffalo_milk' => 'nullable|numeric',
            'tm_skimmed_buffalo_milk' => 'nullable|numeric',
            'tm_total_buffalo_milk' => 'nullable|numeric',
            'tm_total_cow_milk' => 'nullable|numeric',
            'tm_skimmed_cow_milk' => 'nullable|numeric',
            'tm_skimmed_milk_provider' => 'nullable|numeric',
            'tm_one_kg' => 'nullable|numeric',
            'tm_five_kg' => 'nullable|numeric',
            'tm_ten_kg' => 'nullable|numeric',
            'tm_culture'    => 'nullable|numeric',

            // STM fields
            'stm_whole_buffalo_milk' => 'nullable|numeric',
            'stm_skimmed_buffalo_milk' => 'nullable|numeric',
            'stm_total_buffalo_milk' => 'nullable|numeric',
            'stm_total_cow_milk' => 'nullable|numeric',
            'stm_skimmed_cow_milk' => 'nullable|numeric',
            'stm_skimmed_milk_provider' => 'nullable|numeric',
            'stm_one_kg' => 'nullable|numeric',
            'stm_five_kg' => 'nullable|numeric',
            'stm_ten_kg' => 'nullable|numeric',
            'stm_culture'    => 'nullable|numeric',

            // DTM fields
            'dtm_whole_buffalo_milk' => 'nullable|numeric',
            'dtm_skimmed_buffalo_milk' => 'nullable|numeric',
            'dtm_total_buffalo_milk' => 'nullable|numeric',
            'dtm_total_cow_milk' => 'nullable|numeric',
            'dtm_skimmed_cow_milk' => 'nullable|numeric',
            'dtm_skimmed_milk_provider' => 'nullable|numeric',
            'dtm_one_kg' => 'nullable|numeric',
            'dtm_five_kg' => 'nullable|numeric',
            'dtm_ten_kg' => 'nullable|numeric',
            'dtm_culture'    => 'nullable|numeric',
        ]);

        $curdBatch = \App\Models\Curdbatch::findOrFail($id);
        $curdBatch->fill($request->only($curdBatch->getFillable()));
        $curdBatch->save();

        return redirect()->route('curd-batch.index')->with('success', 'Curd Batch updated successfully!');
    }



    /**
     * Delete a specific curdbatch.
     */
    public function destroy($id)
    {
        $curdbatch = CurdBatch::findOrFail($id);
        $curdbatch->delete();

        return redirect()->route('curd-batch.index')->with('success', 'Curd Batch deleted successfully!');
    }
}

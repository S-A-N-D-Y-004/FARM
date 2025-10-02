<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurdDispatchUnit;
use App\Models\CurdBatch;
use App\Models\CurdbatchName;
use Illuminate\Support\Facades\DB;

class CurdDispatchUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $curdbatchNames = CurdbatchName::all();
       
    //     $dispatchUnits = CurdDispatchUnit::orderBy('date', 'desc')->paginate(10);
    
    //     $dispatchUnits = CurdDispatchUnit::orderBy('date', 'desc')->get();
    //     $curdBatch = CurdBatch::all(); // or filter by date if needed
    //     $record = CurdBatch::join('curd_dispatch_units', DB::raw('DATE(curdbatch.date)'), '=', DB::raw('DATE(curd_dispatch_units.date)'))
    //     ->select('curdbatch.tm_one_kg', 'curd_dispatch_units.tonned_milk_1kg')
    //     ->addSelect(DB::raw('(tm_one_kg - tonned_milk_1kg) as remaining_1kg'))
    //     ->whereDate('curdbatch.date', '2025-04-12')
    //     ->first();    

    //     return view('app.curd-dispatch.index', compact('curdbatchNames', 'dispatchUnits','curdBatch','record'));
    // }
    public function index()
    {
        $curdbatchNames = CurdbatchName::all();
    
        // Keep $dispatchUnits as a paginated collection
        $dispatchUnits = CurdDispatchUnit::orderBy('date', 'desc')->paginate(10);
    
        $curdBatch = CurdBatch::all(); // or filter by date if needed
        $record = CurdBatch::join('curd_dispatch_units', DB::raw('DATE(curdbatch.date)'), '=', DB::raw('DATE(curd_dispatch_units.date)'))
            ->select('curdbatch.tm_one_kg', 'curd_dispatch_units.tonned_milk_1kg')
            ->addSelect(DB::raw('(tm_one_kg - tonned_milk_1kg) as remaining_1kg'))
            ->whereDate('curdbatch.date', '2025-04-12')
            ->first();
    
        return view('app.curd-dispatch.index', compact('curdbatchNames', 'dispatchUnits', 'curdBatch', 'record'));
    }
    public function create()
    {
        $existingDates = DB::table('curd_dispatch_units')->pluck('date')->toArray();
        $batchNames = CurdBatch::select('name')->distinct()->get();
        return view('app.curd-dispatch.create', compact('batchNames','existingDates'));
    }

    public function store(Request $request)
    {
        $dispatch = new CurdDispatchUnit();
        $dispatch->date = $request->input('date');

        $categories = [
            'tonned_milk',
            'double_tonned_milk',
            'standard_tonned_milk',
        ];

        foreach ($categories as $category) {
            foreach (['1kg', '5kg', '10kg'] as $size) {
                $field = "{$category}_{$size}";
                $dispatch->$field = $request->input($field, 0);

                // Fetch corresponding curd_batch record
                $curdBatch = CurdBatch::where('name', ucfirst(str_replace('_', ' ', $category)))
                    ->where('date', $dispatch->date)
                    ->first();

                if ($curdBatch) {
                    $remainingField = "remaining_{$category}_{$size}";
                    $dispatch->$remainingField = max(0, $curdBatch->$field - $dispatch->$field);
                }
            }
        }

        $dispatch->save();

        return redirect()->route('curd-dispatch.index')->with('success', 'Dispatch saved successfully.');
    }


    public function edit($id)
    {
        $batchNames = CurdBatch::all(); // or however you're getting batch names
        $dispatch = CurdDispatchUnit::findOrFail($id);
        return view('app.curd-dispatch.edit', [

            'batchNames' => $batchNames,
            'dispatchUnits' => CurdDispatchUnit::all(),
            'dispatch' => $dispatch,
        ]);
    }


    public function update(Request $request, $id)
    {
        $dispatch = CurdDispatchUnit::findOrFail($id);
        $date = $request->input('date');
        $dispatch->date = $date;

        // Optional: if you still want to use name
        // $dispatch->name = $request->input('name');

        // Get all milk values except token/method/date/name
        $data = $request->except(['_token', '_method', 'date', 'name']);

        // Fetch original batch to calculate remaining
        $curdBatch = CurdBatch::where('id', $dispatch->batch_id)
            ->where('date', $date)
            ->first();

        foreach ($data as $key => $value) {
            $dispatch->$key = $value;
            $remainingKey = 'remaining_' . $key;

            if ($curdBatch && isset($curdBatch->$key)) {
                $dispatch->$remainingKey = max(0, $curdBatch->$key - $value);
            }
        }

        $dispatch->save();

        return redirect()->route('curd-dispatch.index')->with('success', 'Dispatch updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dispatch = CurdDispatchUnit::findOrFail($id);
        $dispatch->delete();

        return redirect()->route('curd-dispatch.index')->with('success', 'Dispatch deleted successfully.');
    }
}

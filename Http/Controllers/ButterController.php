<?php

namespace App\Http\Controllers;
use App\Models\ButterModel; 
use Illuminate\Http\Request;
use App\Http\Requests\StoreButterRequest;
use App\Http\Requests\ButterUpdateRequest;
use Illuminate\Support\Facades\DB;


class ButterController extends Controller
{
    
    public function index()
    {
        // Step 1: Get paginated + descending ordered butter records with ghee relation
        $butter = ButterModel::with('ghee')
            ->orderBy('date', 'desc')
            ->paginate(10); // 👈 Corrected this from 'pagination'
    
        // Step 2: Transform the paginated collection if needed
        $butter->getCollection()->transform(function ($item) {
            // Do your logic here, like calculations or adding fields
            return $item;
        });
    
        // Step 3: Pass to view
        return view('app.butter.index', compact('butter'));
    }
    

    public function create()
    {
        $existingDates = DB::table('butter')->pluck('date')->toArray();
        return view('app.butter.create', compact('existingDates'));
    }
    public function store(StoreButterRequest $request)
    {
        // Check if the date already exists
        if (ButterModel::where('date', $request->date)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['date' => 'Entry for this date already exists.']);
        }

        ButterModel::create($request->validated());
        return redirect()->route('butter.index')->with('success', 'Butter added successfully.');
    }
    public function show(string $id)
    {
        
        $butter = ButterModel::findOrFail($id);
        
        return view('app.butter.show', compact('butter'));
        
    }
    public function edit(string $id)
    {
        $butter = ButterModel::findOrFail($id);
        return view('app.butter.edit', compact('butter'));
    }


public function update(ButterUpdateRequest $request, ButterModel $butter)
{
    $butter->update($request->all());
    return redirect()->route('butter.index')->with('success', 'Butter production entry updated.');
}
 
 
    
    public function destroy(string $id)
    {
        ButterModel::findOrFail($id)->delete();

        return redirect()->route('butter.index')->with('success', 'Butter deleted successfully!');
    }
}

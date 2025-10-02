<?php

namespace App\Http\Controllers;
use App\Models\Ghee; 
use Illuminate\Http\Request;
use App\Http\Requests\GheeProductionRequest;
use App\Models\ButterModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class GheeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $ghee = Ghee::orderBy('date', 'desc') // Replace 'date' with your actual column
        ->paginate(10); // 👈 10 items per page

    // Calculate remaining values for paginated items
    $ghee->getCollection()->transform(function ($item) {
        $item->remaining_buffalo_ghee = $item->output_buffalo_ghee - $item->dispatch_buffalo_ghee;
        $item->remaining_cow_ghee = $item->output_cow_ghee - $item->dispatch_cow_ghee;
        $item->ghee_remaining_total = $item->remaining_buffalo_ghee + $item->remaining_cow_ghee;
        return $item;
    });

    return view('app.ghee.index', compact('ghee'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $existingDates = DB::table('ghees')->pluck('date')->toArray();
        $ghee = null;
        return view('app.ghee.create',compact('ghee', 'existingDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
 
    public function store(Request $request)
    {
        // Validate and create the Ghee record
        $ghee = Ghee::create($request->all());
    
        // Now update the related Butter record
        $butter = ButterModel::where('date', $ghee->date)->first();
    
        if ($butter) {
            $buffaloUsed = $ghee->used_buffalo_butter ?? 0;
            $cowUsed = $ghee->used_cow_butter ?? 0;
    
            $butter->remaining_buffalo_butter = ($butter->output_buffalo_butter ?? 0) - $buffaloUsed - ($butter->dispatch_buffalo_butter ?? 0);
            $butter->remaining_cow_butter = ($butter->output_cow_butter ?? 0) - $cowUsed - ($butter->dispatch_cow_butter ?? 0);
            $butter->butter_remaining_total = $butter->remaining_buffalo_butter + $butter->remaining_cow_butter;
    
            $butter->save();
        }
    
        return redirect()->route('ghee.index')->with('success', 'Ghee created and butter remaining recalculated!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $ghee = Ghee::findOrFail($id);
        
        return view('app.ghee.show', compact('ghee'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ghee = Ghee::findOrFail($id);
        return view('app.ghee.edit', compact('ghee'));
    }

    /**
     * Update the specified resource in storage.
     */
  /**
 * @param \App\Http\Requests\GheeProductionRequest $request
 */

public function update(Request $request, $id)
{
    $ghee = Ghee::findOrFail($id);

    // Update Ghee values
    $ghee->update($request->all());

    // Now update the related Butter record
    $butter = ButterModel::where('date', $ghee->date)->first();

    if ($butter) {
        $buffaloUsed = $ghee->used_buffalo_butter ?? 0;
        $cowUsed = $ghee->used_cow_butter ?? 0;

        $butter->remaining_buffalo_butter = ($butter->output_buffalo_butter ?? 0) - $buffaloUsed - ($butter->dispatch_buffalo_butter ?? 0);
        $butter->remaining_cow_butter = ($butter->output_cow_butter ?? 0) - $cowUsed - ($butter->dispatch_cow_butter ?? 0);
        $butter->butter_remaining_total = $butter->remaining_buffalo_butter + $butter->remaining_cow_butter;

        $butter->save();
    }

    return redirect()->route('ghee.index')->with('success', 'Ghee updated and butter remaining recalculated!');
}

   
    public function destroy(string $id)
    {
        ghee::findOrFail($id)->delete();

        return redirect()->route('ghee.index')->with('success', 'Product deleted successfully!');
    }
}

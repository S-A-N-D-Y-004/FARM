<?php

namespace App\Http\Controllers;
use App\Models\CurdReturn;
use App\Http\Requests\CurdReturnUpdate; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurdReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curdReturn = CurdReturn::all();
        // Sort by date in descending order
        $curdReturn = CurdReturn::orderBy('date', 'desc')->paginate(10)->withQueryString();

        return view('app.curd-return.index', compact('curdReturn'));
        

    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $existingDates = DB::table('curd_returns')->pluck('date')->toArray();
        return view('app.curd-return.create', compact('existingDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
  

    public function store(Request $request)
    {
        CurdReturn::create($request->all());
    
        return redirect()->route('curd-return.index')->with('success', 'Return Curd was entered Successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $curdReturn = CurdReturn::findOrFail($id);
        return view('app.curd-return.show', compact('curdReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $curdReturn = CurdReturn::findOrFail($id);
        return view('app.curd-return.edit', compact('curdReturn'));
    }
    
   
    // public function update(CurdReturnUpdate $request, $id)
    // {
    //     $curdReturn = CurdReturn::findOrFail($id);
    //     $curdReturn->update($request->validated());
    
    //     return redirect()->route('curd-return.index')->with('success', 'Return Curd entry updated.');
    // }
    
   
    public function update(Request $request, $id)
    {
        $curdReturn = CurdReturn::findOrFail($id); // fetch existing record by ID
        $curdReturn->update($request->all());      // update the existing record
    
        return redirect()->route('curd-return.index')->with('success', 'Curd return updated successfully.');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CurdReturn::findOrFail($id)->delete();

        return redirect()->route('curd-return.index')->with('success', 'Curd Return deleted successfully!');
    }
}

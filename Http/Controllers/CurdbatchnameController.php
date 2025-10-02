<?php

namespace App\Http\Controllers;

use App\Models\CurdbatchName;
use Illuminate\Http\Request;

class CurdbatchnameController extends Controller
{
    public function index()
    {
        $curdbatches = CurdbatchName::all();
        return view('app.curdbatches.index', compact('curdbatches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.curdbatches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:curdbatch_name,name',
        ]);

        CurdbatchName::create([
            'name' => $request->name,
        ]);

        return redirect()->route('curdbatches.index')->with('success', 'Curd Batch added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CurdbatchName $curdbatch)
    {
        return view('curdbatches.show', compact('curdbatch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CurdbatchName $curdbatch)
    {
        return view('curdbatches.edit', compact('curdbatch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CurdbatchName $curdbatch)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:curdbatch_name,name,' . $curdbatch->id,
        ]);

        $curdbatch->update([
            'name' => $request->name,
        ]);

        return redirect()->route('curdbatches.index')->with('success', 'Curd Batch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurdbatchName $curdbatch)
    {
        $curdbatch->delete();
        return redirect()->route('curdbatches.index')->with('success', 'Curd Batch deleted successfully.');
    }
}

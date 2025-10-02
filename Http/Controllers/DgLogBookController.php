<?php

namespace App\Http\Controllers;

use App\Http\Requests\DGTimeStoreRequest;
use App\Http\Requests\DGTimeUpdateRequest;
use App\Models\DgLogbook;
use Illuminate\Http\Request;

class DgLogBookController extends Controller
{

    public function index()
    {
        $dglog = DgLogbook::all();
        // Sort by date in descending order
        $dglog = DgLogbook::orderBy('date', 'desc')->get();

        $dglog = DgLogbook::latest()->paginate(10);
        return view('app.dg-log.index', compact('dglog'));
    }

    public function create()
    {
        return view('app.dg-log.create');
    }

    public function store(DGTimeStoreRequest $request)
    {
        DgLogbook::create($request->validated());

        return redirect()->route('dg-log.index')->with('success', 'DG log book saved successfully.');
    }


    public function show(string $id)
    {

        $dglog = DgLogbook::findOrFail($id);

        return view('app.dg-log.show', compact('dglog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dglog = Dglogbook::findOrFail($id);
        return view('app.dg-log.edit', compact('dglog'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'added_fuel' => 'nullable|numeric',
        ]);

        $dglog = DgLogbook::findOrFail($id);
        $dglog->update($request->only('date', 'start_time', 'end_time', 'added_fuel'));

        return redirect()->back()->with('success', 'DG Log updated successfully.');
    }




    public function destroy(string $id)
    {
        DgLogbook::findOrFail($id)->delete();

        return redirect()->route('dg-log.index')->with('success', 'Dg-log Book deleted successfully!');
    }
}

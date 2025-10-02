<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Cream;
use Illuminate\Support\Facades\DB;

class CreamController extends Controller
{
    public function index()
    {
        $creams = Cream::with('ghee', 'butter')
            ->orderBy('date', 'desc')
            ->paginate(10);
    
        // Transform the collection *inside* the paginator
        $creams->getCollection()->transform(function ($cream) {
            $cream->cream_remaining_total = 
                ($cream->remaining_buffalo_cream ?? 0) + 
                ($cream->remaining_cow_cream ?? 0);
            return $cream;
        });
    
        return view('app.creams.index', compact('creams'));
    }
    

    public function create() {

        $existingDates = DB::table('creams')->pluck('date')->toArray();
        return view('app.creams.create',compact('existingDates'));
    }


    public function store(Request $request) {
        $data = $request->all();
        // $data['total_wasted_buffalo_cream'] = $data['wasted_buffalo_cream_ghee'] + $data['wasted_buffalo_cream_butter'];
        // $data['total_wasted_cow_cream'] = $data['wasted_cow_cream_ghee'] + $data['wasted_cow_cream_butter'];

        // $data['total_used_buffalo_cream'] = $data['used_buffalo_cream_ghee'] + $data['used_buffalo_cream_butter'];
        // $data['total_used_cow_cream'] = $data['used_cow_cream_ghee'] + $data['used_cow_cream_butter'];

        // $data['remaining_buffalo_cream'] = $data['buffalo_cream_output'] - ($data['total_used_buffalo_cream'] + $data['total_wasted_buffalo_cream'] + $data['dispatched_buffalo_cream']);
        // $data['remaining_cow_cream'] = $data['cow_cream_output'] - ($data['total_used_cow_cream'] + $data['total_wasted_cow_cream'] + $data['dispatched_cow_cream']);

        Cream::create($data);
        return redirect()->route('creams.index')->with('success', 'Cream data added successfully.');
    }

    public function edit(Cream $cream) {
        return view('app.creams.edit', compact('cream'));
    }

    public function update(Request $request, Cream $cream) {
        $data = $request->all();
        $cream->remaining_buffalo_cream = 
        ($cream->buffalo_cream_output ?? 0) 
        - ($cream->dispatched_buffalo_cream ?? 0) 
        - ($cream->ghee->used_buffalo_cream ?? 0) 
        - ($cream->butter->used_buffalo_cream ?? 0);
    
    $cream->remaining_cow_cream = 
        ($cream->cow_cream_output ?? 0) 
        - ($cream->dispatched_cow_cream ?? 0) 
        - ($cream->ghee->used_cow_cream ?? 0) 
        - ($cream->butter->used_cow_cream ?? 0);
    
    $cream->save();
        // $data['total_wasted_buffalo_cream'] = $data['wasted_buffalo_cream_ghee'] + $data['wasted_buffalo_cream_butter'];
        // $data['total_wasted_cow_cream'] = $data['wasted_cow_cream_ghee'] + $data['wasted_cow_cream_butter'];

        // $data['total_used_buffalo_cream'] = $data['used_buffalo_cream_ghee'] + $data['used_buffalo_cream_butter'];
        // $data['total_used_cow_cream'] = $data['used_cow_cream_ghee'] + $data['used_cow_cream_butter'];

        // $data['remaining_buffalo_cream'] = $data['buffalo_cream_output'] - ($data['total_used_buffalo_cream'] + $data['total_wasted_buffalo_cream'] + $data['dispatched_buffalo_cream']);
        // $data['remaining_cow_cream'] = $data['cow_cream_output'] - ($data['total_used_cow_cream'] + $data['total_wasted_cow_cream'] + $data['dispatched_cow_cream']);

        $cream->update($data);
        return redirect()->route('creams.index')->with('success', 'Cream data updated successfully.');
    }

    public function destroy(Cream $cream) {
        $cream->delete();
        return redirect()->route('creams.index')->with('success', 'Cream data deleted successfully.');
    }
}

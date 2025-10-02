<?php

namespace App\Http\Controllers;

use App\Models\CurdforCustomer;
use App\Models\Customer;
use Illuminate\Http\Request;

class CurdforCustomers extends Controller
{
    public function index()
    {
        $curdEntries = CurdforCustomer::orderBy("created_at", "desc")->paginate(10);
        $customers = Customer::paginate(10);
        $curdRecords = CurdforCustomer::with('customer')->paginate(10);

        return view('app.curd-for-customers.index', compact('curdEntries', 'customers', 'curdRecords'));
    }
    public function create()
    {
        $customers = Customer::all();
        // Logic to show the form for creating a new curd entry
        return view('app.curd-for-customers.create', compact('customers'));
    }
    public function store(Request $request)
    {
        // Logic to store curd for customers
        // Validate and save the data
        $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'tm_1kg' => 'nullable|numeric',
            'tm_5kg' => 'nullable|numeric',
            'tm_10kg' => 'nullable|numeric',
            'stm_1kg' => 'nullable|numeric',
            'stm_5kg' => 'nullable|numeric',
            'stm_10kg' => 'nullable|numeric',
            'dtm_1kg' => 'nullable|numeric',
            'dtm_5kg' => 'nullable|numeric',
            'dtm_10kg' => 'nullable|numeric',
        ]);

        CurdforCustomer::create($request->all());

        return redirect()->route('curd-for-customers.index')->with('success', 'Curd entry created successfully.');
    }
    public function show($id)
    {
        $customer = Customer::with('curdForCustomers')->findOrFail($id);
        return view('app.curd-for-customers.show', compact('customer'));
    }
    public function edit(CurdforCustomer $curdforCustomer)
    {
        $customers = Customer::all();
        $curdforCustomer = CurdforCustomer::findOrFail($curdforCustomer->id);
        return view('app.curd-for-customers.edit', compact('curdforCustomer', 'customers'));
    }
    public function update(Request $request, CurdforCustomer $curdforCustomer)
    {
        // Logic to update a specific curd entry
        $request->validate([
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'tm_1kg' => 'nullable|numeric',
            'tm_5kg' => 'nullable|numeric',
            'tm_10kg' => 'nullable|numeric',
            'stm_1kg' => 'nullable|numeric',
            'stm_5kg' => 'nullable|numeric',
            'stm_10kg' => 'nullable|numeric',
            'dtm_1kg' => 'nullable|numeric',
            'dtm_5kg' => 'nullable|numeric',
            'dtm_10kg' => 'nullable|numeric',
        ]);
        $curdforCustomer->update($request->all());
        return redirect()->route('curd-for-customers.index')->with('success', 'Curd entry updated successfully.');
    }
    public function destroy(CurdforCustomer $curdforCustomer)
    {
        // Logic to delete a specific curd entry
        $curdforCustomer->delete();
        return redirect()->route('curd-for-customers.index')->with('success', 'Curd entry deleted successfully.');
    }
}

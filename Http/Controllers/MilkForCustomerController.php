<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersMilkStoreRequest;
use App\Http\Requests\CustomersMilkUpdateRequest;
use Illuminate\Http\Request;
use App\Models\MilkForCustomer;
use App\Models\Customer;

class MilkForCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $milkRecords = MilkForCustomer::with('customer')->get();
        $totalBuffaloMilk = $milkRecords->sum('buffalo_milk'); // Calculate total buffalo milk
        $totalCowMilk = $milkRecords->sum('cow_milk');
        $customers = Customer::all();
        $milkEntries = MilkForCustomer::all();

        $milkEntries = MilkForCustomer::with('customer')->paginate(10);

        $milkRecords = MilkForCustomer::paginate(10); // or whatever logic you're using
        $customers = Customer::paginate(10);

        return view('app.milk-for-customers.index', compact('milkRecords', 'customers', 'milkEntries'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('app.milk-for-customers.create', compact('customers'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'buffalo_milk' => 'required|numeric|min:0',
            'cow_milk' => 'required|numeric|min:0',
            'customer_id' => 'required|exists:customers,id',
        ]);

        // Check if an entry for the same date already exists
        $existingEntry = MilkForCustomer::where('date', $validated['date'])
            ->where('customer_id', $validated['customer_id']) // Match by customer_id
            ->first();

        if ($existingEntry) {
            // Update the existing entry by summing the milk quantities
            $existingEntry->buffalo_milk += $validated['buffalo_milk'];
            $existingEntry->cow_milk += $validated['cow_milk'];
            $existingEntry->save();
        } else {
            // Create a new entry
            MilkForCustomer::create($validated);
        }

        return redirect()->back()->with('success', 'Milk entry saved successfully!');
    }


    // public function show(MilkForCustomer $milkForCustomer)
    // {
    //     return view('milk-for-customers.show', compact('milkForCustomer'));
    // }

    public function show($id)
    {
        $customer = Customer::with('milkForCustomers')->findOrFail($id);

        // Return the partial view for the modal
        return view('app.milk-for-customers.show', compact('customer'));
    }



    public function edit(MilkForCustomer $milkForCustomer)
    {
        $customers = Customer::all();
        return view('milk-for-customers.edit', compact('milkForCustomer', 'customers'));
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'buffalo_milk' => 'required|numeric|min:0',
            'cow_milk' => 'required|numeric|min:0',
            'customer_id' => 'required|exists:customers,id', // Validate customer_id
        ]);

        $milkRecord = MilkForCustomer::findOrFail($id);

        // Check if the date is being updated to an existing record's date
        $existingEntry = MilkForCustomer::where('date', $validated['date'])
            ->where('customer_id', $validated['customer_id']) // Match by customer_id
            ->where('id', '!=', $milkRecord->id)
            ->first();

        if ($existingEntry) {
            // Sum the milk quantities with the existing entry
            $existingEntry->buffalo_milk += $validated['buffalo_milk'];
            $existingEntry->cow_milk += $validated['cow_milk'];
            $existingEntry->save();

            // Delete the current record since its data is merged
            $milkRecord->delete();
        } else {
            // Update the current record
            $milkRecord->update($validated);
        }

        return redirect()->route('milk-for-customers.index')->with('success', 'Milk entry updated successfully!');
    }


    public function destroy(MilkForCustomer $milkForCustomer)
    {
        $milkForCustomer->delete();
        return redirect()->route('milk-for-customers.index')->with('success', 'Milk entry deleted.');
    }
}

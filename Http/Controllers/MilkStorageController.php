<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilkStorageStoreRequest;
use App\Http\Requests\MilkStorageUpdateRequest;
use App\Models\MilkStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\PaneerProduction;
use App\Models\Cream;
use App\Models\Ghee;
use App\Models\ButterModel;
use App\Models\CurdDispatchUnit;
use Carbon\Carbon;
use App\Models\Curdbatch;

class MilkStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MilkStorage::with('vendor');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $milkStorages = $query->get();

        $vendors = Vendor::all();
        // Summary records for tab 1 (date-wise sum)
        $milkSummaries = DB::table('milk_storage')
            ->select(
                'date',
                DB::raw('SUM(total_buffalo) as total_buffalo'),
                DB::raw('SUM(total_cow) as total_cow')
            )
            ->groupBy('date')
            ->orderByDesc('date')
            ->paginate(10);
        $vendorId = $request->vendor_id;
        $date = $request->date;
        $milkStorageRecords = MilkStorage::where('vendor_id', $vendorId)
            ->whereDate('date', $date)
            ->get();
        $records = MilkStorage::where('vendor_id', $vendorId)
            ->whereDate('date', $date)
            ->get();
        
        // $latestMilkStorage = MilkStorage::latest('date')->first();
        // $milkStorages = MilkStorage::with('vendor')->latest()->paginate(10);
        // $milkSummaries = MilkStorage::latest()->paginate(10);

        $milkStorages = MilkStorage::with('vendor')->latest()->paginate(10);
        $latestMilkStorage = MilkStorage::latest('date')->first();
        
        
        return view('app.milk-storage.index', compact('milkStorages', 'milkSummaries', 'vendors', 'records', 'milkStorageRecords', 'latestMilkStorage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $existingDates = DB::table('curdbatch')->pluck('date')->toArray();
        $vendors = Vendor::all();
        return view('app.milk-storage.create', compact('vendors', 'existingDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MilkStorageStoreRequest $request)
    {
        MilkStorage::create($request->validated());
        return redirect()->route('milk-storage.index')->with('success', 'Milk Storage record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MilkStorage $milkStorage)

    {
        $milkSummaries = DB::table('milk_storage')
            ->select(
                'date',
                DB::raw('SUM(total_buffalo) as total_buffalo'),
                DB::raw('SUM(total_cow) as total_cow')
            )
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        $productions = DB::table('milk_production')
            ->select(
                'date',
                DB::raw('SUM(total_buffalo_milk) as total_buffalo_milk'),
                DB::raw('SUM(total_cow_milk) as total_cow_milk')
            )
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        $milkreturn = DB::table('return_milk')
            ->select(
                'date',
                DB::raw('SUM(total_buffalo_milk) as total_buffalo_milk'),
                DB::raw('SUM(total_cow_milk) as total_cow_milk')
            )
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        $paneers = DB::table('paneer_productions')
            ->select(
                'date',
                'buffalo_milk',
                'cow_milk'
            )
            ->groupBy('date', 'buffalo_milk', 'cow_milk')
            ->orderByDesc('date')
            ->get();

        $creams = DB::table('creams')
            ->select(
                'date',
                'used_buffalo_milk',
                'used_cow_milk'
            )
            ->groupBy('date', 'used_buffalo_milk', 'used_cow_milk')
            ->orderByDesc('date')
            ->get();

        $curds = DB::table('curdbatch')
            ->select(
                'date',
                DB::raw('SUM(tm_total_buffalo_milk + stm_total_buffalo_milk + dtm_total_buffalo_milk) as total_buffalo_milk'),
                DB::raw('SUM(tm_total_cow_milk + stm_total_cow_milk + dtm_total_cow_milk) as total_cow_milk')
            )
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        $milkforcustomers = DB::table('milk_for_customers')
            ->select(
                'date',
                DB::raw('SUM(buffalo_milk) as buffalo_milk'),
                DB::raw('SUM(cow_milk) as cow_milk')
            )
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        $currentDate = Carbon::today()->format('Y-m-d');



        return view('app.milk-storage.show', compact('milkStorage', 'paneers', 'creams', 'milkforcustomers', 'curds', 'milkSummaries', 'productions', 'milkreturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MilkStorage $milkStorage)
    {
        $vendors = Vendor::all();
        return view('app.milk-storage.edit', compact('milkStorage', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MilkStorageUpdateRequest $request, MilkStorage $milkStorage)
    {
        $milkStorage->update($request->validated());
        return redirect()->route(route: 'milk-storage.index')->with('success', 'Milk Storage record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MilkStorage $milkStorage)
    {
        $milkStorage->delete();
        return redirect()->route('milk-storage.index')->with('success', 'Milk Storage record deleted successfully!');
    }
    public function getDetails(Request $request)
    {
        $vendorId = $request->input('vendor');
        $date = $request->input('date');

        if (!$vendorId || !$date) {
            return response("Missing vendor or date", 400);
        }

        $record = MilkStorage::where('vendor_id', $vendorId)
            ->where('date', $date)
            ->first();

        return view('app.milk-storage._details', compact('record'));
    }
}

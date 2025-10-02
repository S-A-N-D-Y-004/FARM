<?php

namespace App\Http\Controllers;

use App\Models\ButterModel;
use Illuminate\Http\Request;
use App\Models\StockInUnit;
use Carbon\Carbon;
use App\Models\PaneerProduction;
use App\Models\Cream;
use App\Models\CurdDispatchUnit;
use App\Models\Ghee;
use App\Models\MilkForCustomer;
use App\Models\Milkproduction;
use App\Models\ReturnMilk;
use App\Models\MilkStorage;
use Illuminate\Support\Facades\DB;
use App\Models\Curdbatch;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Yogurt;
use App\Models\ClosingStock;
use App\Models\CurdforCustomer;

class StockInUnitController extends Controller
{
    public function index()
    {
        $startDate = Carbon::parse(MilkStorage::min('date'));
        $endDate = Carbon::today();

        $dates = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates[] = $date->copy();
        }
        // Sort descending so latest dates appear first
        $datesCollection = collect($dates)->sortByDesc(null)->values();

        // Step 3: Paginate manually
        $currentPage = request()->get('page', 1); // Get current page or default to 1
        $perPage = 10; // Set items per page
        $pagedDates = new LengthAwarePaginator(
            $datesCollection->forPage($currentPage, $perPage),
            $datesCollection->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Pre-fetch all records and group by date
        $paneers = PaneerProduction::orderBy('date')->get()->groupBy('date');
        $creams = Cream::orderBy('date')->get()->groupBy('date');
        $ghees = Ghee::orderBy('date')->get()->groupBy('date');
        $butters = ButterModel::orderBy('date')->get()->groupBy('date');
        $curds = CurdDispatchUnit::orderBy('date')->get()->groupBy('date');
        $milks = MilkStorage::orderBy('date')->get()->groupBy('date');
        $yogurt = Yogurt::orderBy('date')->get()->groupBy('date');
        $curdsForCustomer = curdforCustomer::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));

        // Determine the active tab
        $activeTab = request()->get('active_tab', 'products'); // Default to 'products'

        // Function to get latest record before or on a date
        $getLatestBefore = function ($grouped, $targetDate) {
            $date = Carbon::parse($targetDate);
            while ($date->gte(Carbon::parse(MilkStorage::min('date')))) {
                $key = $date->format('Y-m-d');
                if (isset($grouped[$key]) && count($grouped[$key])) {
                    return $grouped[$key]->last(); // or ->first() based on preference
                }
                $date->subDay();
            }
            return null;
        };

        // Paneer cumulative (already present)
        $cumulativePaneer = [];
        $carry_mixed = 0;
        $carry_buffalo = 0;
        $carry_cow = 0;
        foreach (collect($dates)->sort() as $date) {
            $dateKey = $date->format('Y-m-d');
            $paneerData = $paneers[$dateKey] ?? collect();

            $carry_mixed += $paneerData->sum('remaining_mixed_paneer');
            $carry_buffalo += $paneerData->sum('remaining_buffalo_paneer');
            $carry_cow += $paneerData->sum('remaining_cow_paneer');

            $cumulativePaneer[$dateKey] = [
                'mixed' => $carry_mixed,
                'buffalo' => $carry_buffalo,
                'cow' => $carry_cow,
                'total' => $carry_mixed + $carry_buffalo + $carry_cow,
            ];
        }

        // Cream cumulative
        $cumulativeCream = [];
        $carry_buffalo_cream = 0;
        $carry_cow_cream = 0;
        foreach (collect($dates)->sort() as $date) {
            $dateKey = $date->format('Y-m-d');
            $creamData = $creams[$dateKey] ?? collect();

            $carry_buffalo_cream += $creamData->sum('remaining_buffalo_cream');
            $carry_cow_cream += $creamData->sum('remaining_cow_cream');

            $cumulativeCream[$dateKey] = [
                'buffalo' => $carry_buffalo_cream,
                'cow' => $carry_cow_cream,
                'total' => $carry_buffalo_cream + $carry_cow_cream,
            ];
        }

        // Yogurt cumulative
        $cumulativeYogurt = [];
        $carry_1kg_yogurt = 0;
        $carry_5kg_yogurt = 0;
        $carry_10kg_yogurt = 0;
        foreach (collect($dates)->sort() as $date) {
            $dateKey = $date->format('Y-m-d');
            $yogurtData = $yogurt[$dateKey] ?? collect();

            $carry_1kg_yogurt += $yogurtData->sum('remaining_one_kg');
            $carry_5kg_yogurt += $yogurtData->sum('remaining_five_kg');
            $carry_10kg_yogurt += $yogurtData->sum('remaining_ten_kg');

            $cumulativeYogurt[$dateKey] = [
                'buffalo' => $carry_1kg_yogurt,
                'cow' => $carry_5kg_yogurt,
                'total' => $carry_10kg_yogurt,
            ];
        }

        // Ghee cumulative
        $cumulativeGhee = [];
        $carry_buffalo_ghee = 0;
        $carry_cow_ghee = 0;
        foreach (collect($dates)->sort() as $date) {
            $dateKey = $date->format('Y-m-d');
            $gheeData = $ghees[$dateKey] ?? collect();

            $carry_buffalo_ghee += $gheeData->sum('remaining_buffalo_ghee');
            $carry_cow_ghee += $gheeData->sum('remaining_cow_ghee');

            $cumulativeGhee[$dateKey] = [
                'buffalo' => $carry_buffalo_ghee,
                'cow' => $carry_cow_ghee,
                'total' => $carry_buffalo_ghee + $carry_cow_ghee,
            ];
        }

        // Butter cumulative
        $cumulativeButter = [];
        $carry_buffalo_butter = 0;
        $carry_cow_butter = 0;
        foreach (collect($dates)->sort() as $date) {
            $dateKey = $date->format('Y-m-d');
            $butterData = $butters[$dateKey] ?? collect();

            $carry_buffalo_butter += $butterData->sum('remaining_buffalo_butter');
            $carry_cow_butter += $butterData->sum('remaining_cow_butter');

            $cumulativeButter[$dateKey] = [
                'buffalo' => $carry_buffalo_butter,
                'cow' => $carry_cow_butter,
                'total' => $carry_buffalo_butter + $carry_cow_butter,
            ];
        }

        // Curd cumulative
        $cumulativeCurd = [];
        $carry_tm_1kg = 0;
        $carry_tm_5kg = 0;
        $carry_tm_10kg = 0;
        $carry_dtm_1kg = 0;
        $carry_dtm_5kg = 0;
        $carry_dtm_10kg = 0;
        $carry_stm_1kg = 0;
        $carry_stm_5kg = 0;
        $carry_stm_10kg = 0;
        foreach (collect($dates)->sort() as $date) {
            $dateKey = $date->format('Y-m-d');
            $curdData = $curds[$dateKey] ?? collect();
            $today_curdforcustomer = $curdsForCustomer[$dateKey] ?? collect();
            // Curd Dispatched to customers
            $dispatched_tm1kg = $today_curdforcustomer->sum('tm_1kg');
            $dispatched_tm5kg = $today_curdforcustomer->sum('tm_5kg');
            $dispatched_tm10kg = $today_curdforcustomer->sum('tm_10kg');
            $dispatched_stm1kg = $today_curdforcustomer->sum('stm_1kg');
            $dispatched_stm5kg = $today_curdforcustomer->sum('stm_5kg');
            $dispatched_stm10kg = $today_curdforcustomer->sum('stm_10kg');
            $dispatched_dtm1kg = $today_curdforcustomer->sum('dtm_1kg');
            $dispatched_dtm5kg = $today_curdforcustomer->sum('dtm_5kg');
            $dispatched_dtm10kg = $today_curdforcustomer->sum('dtm_10kg');

            // Subtract dispatched to customers from remaining
            $carry_tm_1kg += $curdData->sum('remaining_tonned_milk_1kg') - $dispatched_tm1kg;
            $carry_tm_5kg += $curdData->sum('remaining_tonned_milk_5kg') - $dispatched_tm5kg;
            $carry_tm_10kg += $curdData->sum('remaining_tonned_milk_10kg') - $dispatched_tm10kg;
            $carry_dtm_1kg += $curdData->sum('remaining_double_tonned_milk_1kg') - $dispatched_dtm1kg;
            $carry_dtm_5kg += $curdData->sum('remaining_double_tonned_milk_5kg') - $dispatched_dtm5kg;
            $carry_dtm_10kg += $curdData->sum('remaining_double_tonned_milk_10kg') - $dispatched_dtm10kg;
            $carry_stm_1kg += $curdData->sum('remaining_standard_tonned_milk_1kg') - $dispatched_stm1kg;
            $carry_stm_5kg += $curdData->sum('remaining_standard_tonned_milk_5kg') - $dispatched_stm5kg;
            $carry_stm_10kg += $curdData->sum('remaining_standard_tonned_milk_10kg') - $dispatched_stm10kg;

            $cumulativeCurd[$dateKey] = [
                'tm_1kg' => $carry_tm_1kg,
                'tm_5kg' => $carry_tm_5kg,
                'tm_10kg' => $carry_tm_10kg,
                'tm_total' => $carry_tm_1kg + $carry_tm_5kg + $carry_tm_10kg,
                'dtm_1kg' => $carry_dtm_1kg,
                'dtm_5kg' => $carry_dtm_5kg,
                'dtm_10kg' => $carry_dtm_10kg,
                'dtm_total' => $carry_dtm_1kg + $carry_dtm_5kg + $carry_dtm_10kg,
                'stm_1kg' => $carry_stm_1kg,
                'stm_5kg' => $carry_stm_5kg,
                'stm_10kg' => $carry_stm_10kg,
                'stm_total' => $carry_stm_1kg + $carry_stm_5kg + $carry_stm_10kg,
            ];
        }

        $remainingStocks = [];

        // Group all datasets by date
        $productions = Milkproduction::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $milkreturns = ReturnMilk::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $paneers = PaneerProduction::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $creams = Cream::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $curd = Curdbatch::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $milksForCustomer = MilkForCustomer::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $milks = MilkStorage::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $yogurt = Yogurt::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));
        $curdsForCustomer = curdforCustomer::get()->groupBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));

        foreach ($dates as $date) {
            $dateKey = $date->format('Y-m-d');
            $lookupKey = $date->copy()->subDay()->format('Y-m-d');

            // Raw milk collected for the day
            $today_milk = $milks[$dateKey] ?? collect();
            $raw_buffalo = $today_milk->sum('total_buffalo');
            $raw_cow = $today_milk->sum('total_cow');

            // Returned milk for the day
            $today_milkreturns = $milkreturns[$dateKey] ?? collect();
            $returned_buffalo = $today_milkreturns->sum('total_buffalo_milk');
            $returned_cow = $today_milkreturns->sum('total_cow_milk');

            // Previous day's remaining
            $prev_remaining = $remainingStocks[$lookupKey] ?? ['buffalo' => 0, 'cow' => 0];
            $prev_remaining_buffalo = $prev_remaining['buffalo'];
            $prev_remaining_cow = $prev_remaining['cow'];

            // Total available for the day
            $total_buffalo = $raw_buffalo + $returned_buffalo + $prev_remaining_buffalo;
            $total_cow = $raw_cow + $returned_cow + $prev_remaining_cow;

            // Used for internal production
            $today_paneer = $paneers[$dateKey] ?? collect();
            $today_cream = $creams[$dateKey] ?? collect();
            $today_curd = $curd[$dateKey] ?? collect();
            $today_yogurt = $yogurt[$dateKey] ?? collect();

            $used_buffalo = $today_paneer->sum('buffalo_milk')
                + $today_cream->sum('used_buffalo_milk')
                + $today_curd->sum('tm_total_buffalo_milk')
                + $today_curd->sum('stm_total_buffalo_milk')
                + $today_curd->sum('dtm_total_buffalo_milk')
                + $today_yogurt->sum('buffalo_milk');

            $used_cow = $today_paneer->sum('cow_milk')
                + $today_cream->sum('used_cow_milk')
                + $today_curd->sum('tm_total_cow_milk')
                + $today_curd->sum('stm_total_cow_milk')
                + $today_curd->sum('dtm_total_cow_milk')
                + $today_yogurt->sum('cow_milk');

            // Dispatched to customers
            $today_milkforcustomer = $milksForCustomer[$dateKey] ?? collect();
            $dispatched_buffalo = $today_milkforcustomer->sum('buffalo_milk');
            $dispatched_cow = $today_milkforcustomer->sum('cow_milk');

            // Add production dispatched milk
            $today_production = $productions[$dateKey] ?? collect();
            $dispatched_buffalo += $today_production->sum('total_buffalo_milk');
            $dispatched_cow += $today_production->sum('total_cow_milk');

            // Remaining calculation
            $remaining_buffalo = $total_buffalo - $used_buffalo - $dispatched_buffalo;
            $remaining_cow = $total_cow - $used_cow - $dispatched_cow;

            $remainingStocks[$dateKey] = [
                'buffalo' => $remaining_buffalo,
                'cow' => $remaining_cow,
            ];
        }

        $startDate = DB::table('milk_storage')->min('date');
        $endDate = now()->toDateString();

        $dates = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($current->lte($end)) {
            $dates[] = $current->copy();
            $current->addDay();
        }

        $openingStock = [];

        // Initial stock (you can set these to 0 or pull from a known first entry)
        $prevOneKg = 0;
        $prevFiveKg = 0;
        $prevTenKg = 0;

        foreach ($dates as $date) {
            $dateStr = $date->format('Y-m-d');

            // Get current day's yogurt production
            $yogurt = DB::table('yogurt')
                ->where('date', $dateStr)
                ->selectRaw('SUM(one_kg) as one_kg, SUM(five_kg) as five_kg, SUM(ten_kg) as ten_kg')
                ->first();

            // Get current day's dispatch
            $dispatch = DB::table('yogurt_dispatch')
                ->where('date', $dateStr)
                ->selectRaw('SUM(one_kg) as one_kg, SUM(five_kg) as five_kg, SUM(ten_kg) as ten_kg')
                ->first();

            // Opening = Previous day's closing
            $openingOneKg = $prevOneKg;
            $openingFiveKg = $prevFiveKg;
            $openingTenKg = $prevTenKg;

            // Closing = Opening + Today’s Production - Dispatch
            $closingOneKg = $openingOneKg + ($yogurt->one_kg ?? 0) - ($dispatch->one_kg ?? 0);
            $closingFiveKg = $openingFiveKg + ($yogurt->five_kg ?? 0) - ($dispatch->five_kg ?? 0);
            $closingTenKg = $openingTenKg + ($yogurt->ten_kg ?? 0) - ($dispatch->ten_kg ?? 0);

            // Store opening for display
            $openingStock[$dateStr] = [
                '1kg' => $openingOneKg,
                '5kg' => $openingFiveKg,
                '10kg' => $openingTenKg,
                'total_units' => $openingOneKg * 1 + $openingFiveKg * 5 + $openingTenKg * 10,
            ];

            // Update for next day's opening
            $prevOneKg = $closingOneKg;
            $prevFiveKg = $closingFiveKg;
            $prevTenKg = $closingTenKg;
        }

        return view('app.opening-stock.index', [
            'dates' => $pagedDates,
            'paneers' => $paneers,
            'creams' => $creams,
            'ghees' => $ghees,
            'butters' => $butters,
            'curds' => $curds,
            'getLatestBefore' => $getLatestBefore,
            'remainingStocks' => $remainingStocks,
            'activeTab' => $activeTab, // Pass activeTab to the view
            'carryPaneerData' => $cumulativePaneer,
            'carryCreamData' => $cumulativeCream,
            'carryGheeData' => $cumulativeGhee,
            'carryButterData' => $cumulativeButter,
            'carryCurdData' => $cumulativeCurd,
            'carryYogurtData' => $cumulativeYogurt,
            'date' => $dates,
            'openingStock' => $openingStock,
        ]);
    }

    public function create()
    {
        return view('stock.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date|unique:stock_in_units,date',

            'mixed_paneer' => 'nullable|integer',
            'buffalo_paneer' => 'nullable|integer',
            'cow_paneer' => 'nullable|integer',
            'total_paneer' => 'nullable|integer',

            // Add validation for the rest fields similarly or use '*' wildcard
        ]);

        StockInUnit::create($data);

        return redirect()->route('stock.index')->with('success', 'Stock entry added.');
    }
    public function showStock()
    {
        $startDate = DB::table('milk_storage')->min('date'); // or created_at
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::now();

        $dates = [];
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $dates[] = $date->copy()->format('Y-m-d');
        }

        // Optional: eager load data for performance
        $paneers = PaneerProduction::whereIn('date', $dates)->get()->keyBy('date');
        $creams = Cream::whereIn('date', $dates)->get()->keyBy('date');
        $ghees = Ghee::whereIn('date', $dates)->get()->keyBy('date');
        $butters = ButterModel::whereIn('date', $dates)->get()->keyBy('date');
        $curds = Curdbatch::whereIn('date', $dates)->get()->keyBy('date');

        return view('stock.opening', compact('dates', 'paneers', 'creams', 'ghees', 'butters', 'curds'));
    }
}

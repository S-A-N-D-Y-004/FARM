<?php

namespace App\Observers;

use App\Models\Curdbatch;
use App\Models\CurdDispatchUnit;

class CurdBatchObserver
{
    public function created(Curdbatch $batch)
    {
        $this->updateDispatchUnits($batch);
    }

    public function updated(Curdbatch $batch)
    {
        $this->updateDispatchUnits($batch);
    }

    private function updateDispatchUnits(Curdbatch $batch)
    {
        $dispatch = CurdDispatchUnit::firstOrNew(['date' => $batch->date]);

        // Tonned Milk
        $tm1 = $batch->tm_one_kg ?? 0;
        $tm5 = $batch->tm_five_kg ?? 0;
        $tm10 = $batch->tm_ten_kg ?? 0;
        $dispatch->remaining_tonned_milk_1kg = $tm1;
        $dispatch->remaining_tonned_milk_5kg = $tm5;
        $dispatch->remaining_tonned_milk_10kg = $tm10;
        $dispatch->tm_total_dispatch = ($tm1 * 1) + ($tm5 * 5) + ($tm10 * 10);

        // Double Tonned Milk
        $dtm1 = $batch->dtm_one_kg ?? 0;
        $dtm5 = $batch->dtm_five_kg ?? 0;
        $dtm10 = $batch->dtm_ten_kg ?? 0;
        $dispatch->remaining_double_tonned_milk_1kg = $dtm1;
        $dispatch->remaining_double_tonned_milk_5kg = $dtm5;
        $dispatch->remaining_double_tonned_milk_10kg = $dtm10;
        $dispatch->dtm_total_dispatch = ($dtm1 * 1) + ($dtm5 * 5) + ($dtm10 * 10);

        // Standard Tonned Milk
        $stm1 = $batch->stm_one_kg ?? 0;
        $stm5 = $batch->stm_five_kg ?? 0;
        $stm10 = $batch->stm_ten_kg ?? 0;
        $dispatch->remaining_standard_tonned_milk_1kg = $stm1;
        $dispatch->remaining_standard_tonned_milk_5kg = $stm5;
        $dispatch->remaining_standard_tonned_milk_10kg = $stm10;
        $dispatch->stm_total_dispatch = ($stm1 * 1) + ($stm5 * 5) + ($stm10 * 10);

        $dispatch->save();
    }
}
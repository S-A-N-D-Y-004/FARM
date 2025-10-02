<?php

namespace App\Observers;

use App\Models\ButterModel;
use App\Models\Ghee;
use App\Models\Cream;

class ButterObserver
{
    public function created(ButterModel $butter)
    {
        $this->updateCreamRemaining($butter);
    }

    public function updated(ButterModel $butter)
    {
        $this->updateCreamRemaining($butter);
    }

    private function updateCreamRemaining(ButterModel $butter)
    {
        $cream = Cream::whereDate('date', $butter->date)->first();
        if ($cream) {
            $buffaloUsedInGhee = Ghee::whereDate('date', $butter->date)->sum('used_buffalo_cream');
            $cowUsedInGhee = Ghee::whereDate('date', $butter->date)->sum('used_cow_cream');

            $remainingBuffaloCream = ($cream->buffalo_cream_output ?? 0)
                - ($cream->dispatched_buffalo_cream ?? 0)
                - ($butter->used_buffalo_cream ?? 0)
                - ($buffaloUsedInGhee ?? 0);

            $remainingCowCream = ($cream->cow_cream_output ?? 0)
                - ($cream->dispatched_cow_cream ?? 0)
                - ($butter->used_cow_cream ?? 0)
                - ($cowUsedInGhee ?? 0);

            $cream->remaining_buffalo_cream = $remainingBuffaloCream;
            $cream->remaining_cow_cream = $remainingCowCream;
            $cream->cream_remaining_total = $remainingBuffaloCream + $remainingCowCream;

            $cream->save();
        }
    }
}

<?php

namespace App\Observers;

use App\Models\Ghee;
use App\Models\ButterModel;
use App\Models\Cream;

class GheeObserver
{
    public function created(Ghee $ghee)
    {
        $this->updateCreamRemaining($ghee);
    }

    public function updated(Ghee $ghee)
    {
        $this->updateCreamRemaining($ghee);
    }

    private function updateCreamRemaining(Ghee $ghee)
    {
        $cream = Cream::whereDate('date', $ghee->date)->first();
        $butter = ButterModel::whereDate('date', $ghee->date)->first();

        if ($cream) {
            $usedBuffaloButter = $butter?->used_buffalo_cream ?? 0;
            $usedCowButter = $butter?->used_cow_cream ?? 0;

            $remainingBuffaloCream = ($cream->buffalo_cream_output ?? 0)
                - ($cream->dispatched_buffalo_cream ?? 0)
                - $usedBuffaloButter
                - ($ghee->used_buffalo_cream ?? 0);

            $remainingCowCream = ($cream->cow_cream_output ?? 0)
                - ($cream->dispatched_cow_cream ?? 0)
                - $usedCowButter
                - ($ghee->used_cow_cream ?? 0);

            $cream->remaining_buffalo_cream = $remainingBuffaloCream;
            $cream->remaining_cow_cream = $remainingCowCream;
            $cream->cream_remaining_total = $remainingBuffaloCream + $remainingCowCream;

            $cream->save();
        }
    }
}

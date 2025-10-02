<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButterModel extends Model
{
    protected $table = 'butter';
        protected $fillable = [
            'date',
            'used_cow_cream',
            'used_buffalo_cream',
            'wastage_cow_cream',
            'wastage_buffalo_cream',
            'output_cow_butter',
            'output_buffalo_butter',
            'dispatch_cow_butter',
            'dispatch_buffalo_butter',
            'remaining_cow_butter',
            'remaining_buffalo_butter',
            'butter_remaining_total',
        ];
        // In ButterModel.php
public function ghee()
{
    return $this->hasOne(Ghee::class, 'date', 'date');
}
protected static function booted()
{
    static::saving(function ($butter) {
        // Get the matching ghee entry for the same date
        $ghee = Ghee::where('date', $butter->date)->first();

        $usedCowButter = $ghee->used_cow_butter ?? 0;
        $usedBuffaloButter = $ghee->used_buffalo_butter ?? 0;

        // Calculate remaining butter
        $butter->remaining_cow_butter = 
            ($butter->output_cow_butter ?? 0)
            - ($butter->dispatch_cow_butter ?? 0);

        $butter->remaining_buffalo_butter = 
            ($butter->output_buffalo_butter ?? 0)
            - ($butter->dispatch_buffalo_butter ?? 0);
            
            //Total remaining butter
            $butter->butter_remaining_total = 
            ($butter->remaining_buffalo_butter ?? 0)
            + ($butter->remaining_cow_butter ?? 0);
    });
}

}

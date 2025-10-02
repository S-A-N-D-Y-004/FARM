<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cream extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'used_buffalo_milk', 'used_cow_milk',
        'buffalo_cream_output', 'cow_cream_output',
        'wasted_buffalo_milk', 'wasted_cow_milk',
        'dispatched_buffalo_cream', 'dispatched_cow_cream',
        'wasted_buffalo_cream_ghee', 'wasted_cow_cream_ghee',
        'wasted_buffalo_cream_butter', 'wasted_cow_cream_butter',
        'skimmed_milk_buffalo', 'skimmed_milk_cow',
        'total_wasted_buffalo_cream', 'total_wasted_cow_cream',
        'used_buffalo_cream_ghee', 'used_cow_cream_ghee',
        'used_buffalo_cream_butter', 'used_cow_cream_butter',
        'total_used_buffalo_cream', 'total_used_cow_cream',
        'remaining_buffalo_cream', 'remaining_cow_cream',
    ];
    public function ghee()
{
    return $this->hasOne(Ghee::class, 'date', 'date');
}
    public function butter()
{
    return $this->hasOne(ButterModel::class, 'date', 'date');
}
protected static function booted()
{
    static::saving(function ($model) {
        self::calculateRemainingCream($model);
    });

    static::updating(function ($model) {
        self::calculateRemainingCream($model);
    });

    static::creating(function ($model) {
        self::calculateRemainingCream($model);
    });
}

private static function calculateRemainingCream($model)
{
    $ghee = Ghee::where('date', $model->date)->first();
    $butter = ButterModel::where('date', $model->date)->first();

    $usedBuffaloCreamGhee = $ghee->used_buffalo_cream ?? 0;
    $usedCowCreamGhee = $ghee->used_cow_cream ?? 0;

    $usedBuffaloCreamButter = $butter->used_buffalo_cream ?? 0;
    $usedCowCreamButter = $butter->used_cow_cream ?? 0;

    $model->remaining_buffalo_cream = 
        ($model->buffalo_cream_output ?? 0) 
        - ($model->dispatched_buffalo_cream ?? 0) 
        - $usedBuffaloCreamGhee 
        - $usedBuffaloCreamButter;

    $model->remaining_cow_cream = 
        ($model->cow_cream_output ?? 0) 
        - ($model->dispatched_cow_cream ?? 0) 
        - $usedCowCreamGhee 
        - $usedCowCreamButter;

    $model->cream_remaining_total = 
        $model->remaining_buffalo_cream 
        + $model->remaining_cow_cream;
}

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurdDispatchUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'name',
        'tonned_milk_1kg', 'tonned_milk_5kg', 'tonned_milk_10kg',
        'double_tonned_milk_1kg', 'double_tonned_milk_5kg', 'double_tonned_milk_10kg',
        'standard_tonned_milk_1kg', 'standard_tonned_milk_5kg', 'standard_tonned_milk_10kg',
        'remaining_tonned_milk_1kg', 'remaining_tonned_milk_5kg', 'remaining_tonned_milk_10kg',
        'remaining_double_tonned_milk_1kg', 'remaining_double_tonned_milk_5kg', 'remaining_double_tonned_milk_10kg',
        'remaining_standard_tonned_milk_1kg', 'remaining_standard_tonned_milk_5kg', 'remaining_standard_tonned_milk_10kg','remaining_overall_tm','remaining_overall_dtm','remaining_overall_stm'
    ];
    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->tm_total_dispatch = ($model->tonned_milk_1kg * 1) + ($model->tonned_milk_5kg * 5) + ($model->tonned_milk_10kg * 10);
            $model->dtm_total_dispatch = ($model->double_tonned_milk_1kg * 1) + ($model->double_tonned_milk_5kg * 5) + ($model->double_tonned_milk_10kg * 10);
            $model->stm_total_dispatch = ($model->standard_tonned_milk_1kg * 1) + ($model->standard_tonned_milk_5kg * 5) + ($model->standard_tonned_milk_10kg * 10);
            $model->remaining_tonned_milk_1kg = $model->getRemaining1kgAttribute();
            $model->remaining_tonned_milk_5kg = $model->getRemaining5kgAttribute();
            $model->remaining_tonned_milk_10kg = $model->getRemaining10kgAttribute();
            $model->remaining_double_tonned_milk_1kg = $model->getRemainingDtm1kgAttribute();
            $model->remaining_double_tonned_milk_5kg = $model->getRemainingDtm5kgAttribute();
            $model->remaining_double_tonned_milk_10kg = $model->getRemainingDtm10kgAttribute();
            $model->remaining_standard_tonned_milk_1kg = $model->getRemainingStm1kgAttribute();
            $model->remaining_standard_tonned_milk_5kg = $model->getRemainingStm5kgAttribute();
            $model->remaining_standard_tonned_milk_10kg = $model->getRemainingStm10kgAttribute();
            $model->remaining_overall_tm = $model->getRemainingTmTotalAttribute();
            $model->remaining_overall_dtm = $model->getRemainingDtmTotalAttribute();
            $model->remaining_overall_stm = $model->getRemainingStmTotalAttribute();
         
            
        });
        static::updating(function ($model) {
            $model->tm_total_dispatch = ($model->tonned_milk_1kg * 1) + ($model->tonned_milk_5kg * 5) + ($model->tonned_milk_10kg * 10);
            $model->dtm_total_dispatch = ($model->double_tonned_milk_1kg * 1) + ($model->double_tonned_milk_5kg * 5) + ($model->double_tonned_milk_10kg * 10);
            $model->stm_total_dispatch = ($model->standard_tonned_milk_1kg * 1) + ($model->standard_tonned_milk_5kg * 5) + ($model->standard_tonned_milk_10kg * 10);
            $model->remaining_tonned_milk_1kg = $model->getRemaining1kgAttribute();
            $model->remaining_tonned_milk_5kg = $model->getRemaining5kgAttribute();
            $model->remaining_tonned_milk_10kg = $model->getRemaining10kgAttribute();
            $model->remaining_double_tonned_milk_1kg = $model->getRemainingDtm1kgAttribute();
            $model->remaining_double_tonned_milk_5kg = $model->getRemainingDtm5kgAttribute();   
            $model->remaining_double_tonned_milk_10kg = $model->getRemainingDtm10kgAttribute();
            $model->remaining_standard_tonned_milk_1kg = $model->getRemainingStm1kgAttribute();
            $model->remaining_standard_tonned_milk_5kg = $model->getRemainingStm5kgAttribute();
            $model->remaining_standard_tonned_milk_10kg = $model->getRemainingStm10kgAttribute();
            $model->remaining_overall_tm = $model->getRemainingTmTotalAttribute();
            $model->remaining_overall_dtm = $model->getRemainingDtmTotalAttribute();
            $model->remaining_overall_stm = $model->getRemainingStmTotalAttribute();

 
        });
        static::deleting(function ($model) {
            $model->tm_total_dispatch = ($model->tonned_milk_1kg * 1) + ($model->tonned_milk_5kg * 5) + ($model->tonned_milk_10kg * 10);
            $model->dtm_total_dispatch = ($model->double_tonned_milk_1kg * 1) + ($model->double_tonned_milk_5kg * 5) + ($model->double_tonned_milk_10kg * 10);
            $model->stm_total_dispatch = ($model->standard_tonned_milk_1kg * 1) + ($model->standard_tonned_milk_5kg * 5) + ($model->standard_tonned_milk_10kg * 10);
            $model->remaining_tonned_milk_1kg = $model->getRemaining1kgAttribute();
            $model->remaining_tonned_milk_5kg = $model->getRemaining5kgAttribute();
            $model->remaining_tonned_milk_10kg = $model->getRemaining10kgAttribute();
            $model->remaining_double_tonned_milk_1kg = $model->getRemainingDtm1kgAttribute();
            $model->remaining_double_tonned_milk_5kg = $model->getRemainingDtm5kgAttribute();
            $model->remaining_double_tonned_milk_10kg = $model->getRemainingDtm10kgAttribute();
            $model->remaining_standard_tonned_milk_1kg = $model->getRemainingStm1kgAttribute();
            $model->remaining_standard_tonned_milk_5kg = $model->getRemainingStm5kgAttribute();
            $model->remaining_standard_tonned_milk_10kg = $model->getRemainingStm10kgAttribute();
            $model->remaining_overall_tm = $model->getRemainingTmTotalAttribute();
            $model->remaining_overall_dtm = $model->getRemainingDtmTotalAttribute();
            $model->remaining_overall_stm = $model->getRemainingStmTotalAttribute();



        });
        static::saving(function ($model) {
            $model->tm_total_dispatch = ($model->tonned_milk_1kg * 1) + ($model->tonned_milk_5kg * 5) + ($model->tonned_milk_10kg * 10);
            $model->dtm_total_dispatch = ($model->double_tonned_milk_1kg * 1) + ($model->double_tonned_milk_5kg * 5) + ($model->double_tonned_milk_10kg * 10);
            $model->stm_total_dispatch = ($model->standard_tonned_milk_1kg * 1) + ($model->standard_tonned_milk_5kg * 5) + ($model->standard_tonned_milk_10kg * 10);
            $model->remaining_tonned_milk_1kg = $model->getRemaining1kgAttribute();
            $model->remaining_tonned_milk_5kg = $model->getRemaining5kgAttribute();
            $model->remaining_tonned_milk_10kg = $model->getRemaining10kgAttribute();
            $model->remaining_double_tonned_milk_1kg = $model->getRemainingDtm1kgAttribute();
            $model->remaining_double_tonned_milk_5kg = $model->getRemainingDtm5kgAttribute();
            $model->remaining_double_tonned_milk_10kg = $model->getRemainingDtm10kgAttribute();
            $model->remaining_standard_tonned_milk_1kg = $model->getRemainingStm1kgAttribute();
            $model->remaining_standard_tonned_milk_5kg = $model->getRemainingStm5kgAttribute();
            $model->remaining_standard_tonned_milk_10kg = $model->getRemainingStm10kgAttribute();
            $model->remaining_overall_tm = $model->getRemainingTmTotalAttribute();
            $model->remaining_overall_dtm = $model->getRemainingDtmTotalAttribute();
            $model->remaining_overall_stm = $model->getRemainingStmTotalAttribute();

        });
  
    }
    public function getRemaining1kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->tm_one_kg ?? 0) - ($this->tonned_milk_1kg ?? 0);
}
// For Tonned Milk
public function getRemaining5kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->tm_five_kg ?? 0) - ($this->tonned_milk_5kg ?? 0);
}

public function getRemaining10kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->tm_ten_kg ?? 0) - ($this->tonned_milk_10kg ?? 0);
}

public function getRemainingTmTotalAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->tm_total ?? 0) - ($this->tm_total_dispatch ?? 0);
}

// For Standard Tonned Milk
public function getRemainingStm1kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->stm_one_kg ?? 0) - ($this->standard_tonned_milk_1kg ?? 0);
}

public function getRemainingStm5kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->stm_five_kg ?? 0) - ($this->standard_tonned_milk_5kg ?? 0);
}

public function getRemainingStm10kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->stm_ten_kg ?? 0) - ($this->standard_tonned_milk_10kg ?? 0);
}

public function getRemainingStmTotalAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->stm_total ?? 0) - ($this->stm_total_dispatch ?? 0);
}

// For Double Tonned Milk
public function getRemainingDtm1kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->dtm_one_kg ?? 0) - ($this->double_tonned_milk_1kg ?? 0);
}

public function getRemainingDtm5kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->dtm_five_kg ?? 0) - ($this->double_tonned_milk_5kg ?? 0);
}

public function getRemainingDtm10kgAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->dtm_ten_kg ?? 0) - ($this->double_tonned_milk_10kg ?? 0);
}

public function getRemainingDtmTotalAttribute()
{
    $batch = CurdBatch::whereDate('date', $this->date)->first();
    return ($batch->dtm_total ?? 0) - ($this->dtm_total_dispatch ?? 0);
}

}

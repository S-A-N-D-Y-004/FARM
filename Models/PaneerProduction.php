<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaneerProduction extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'buffalo_milk',
        'cow_milk',
        'output_buffalo_paneer',
        'output_cow_paneer',
        'output_mixed_paneer',
        'buffalo_milk_wastage',
        'cow_milk_wastage',
        'dispatch_buffalo_paneer',
        'dispatch_cow_paneer',
        'dispatch_mixed_paneer',
        'remaining_buffalo_paneer',
        'remaining_cow_paneer',
        'remaining_mixed_paneer',
    ];
    public function getRemainingBuffaloPaneerAttribute()
{
    return $this->output_buffalo_paneer - $this->dispatch_buffalo_paneer;
}
    public function getRemainingCowPaneerAttribute()
{
    return $this->output_cow_paneer - $this->dispatch_cow_paneer;
}

    public function getRemainingMixedPaneerAttribute()
{
    return $this->output_mixed_paneer - $this->dispatch_mixed_paneer;
}
protected static function booted(){
    static::creating(function ($model) {
        $model->remaining_buffalo_paneer = $model->output_buffalo_paneer - $model->dispatch_buffalo_paneer;
        $model->remaining_cow_paneer = $model->output_cow_paneer - $model->dispatch_cow_paneer;
        $model->remaining_mixed_paneer = $model->output_mixed_paneer - $model->dispatch_mixed_paneer;
        $model->paneer_remaining_total = $model->remaining_buffalo_paneer + $model->remaining_cow_paneer + $model->remaining_mixed_paneer;
    });

    static::updating(function ($model) {
        $model->remaining_buffalo_paneer = $model->output_buffalo_paneer - $model->dispatch_buffalo_paneer;
        $model->remaining_cow_paneer = $model->output_cow_paneer - $model->dispatch_cow_paneer;
        $model->remaining_mixed_paneer = $model->output_mixed_paneer - $model->dispatch_mixed_paneer;
        $model->paneer_remaining_total = $model->remaining_buffalo_paneer + $model->remaining_cow_paneer + $model->remaining_mixed_paneer;
    }); 
    static::deleting(function ($model) {
        $model->remaining_buffalo_paneer = $model->output_buffalo_paneer - $model->dispatch_buffalo_paneer;
        $model->remaining_cow_paneer = $model->output_cow_paneer - $model->dispatch_cow_paneer;
        $model->remaining_mixed_paneer = $model->output_mixed_paneer - $model->dispatch_mixed_paneer;
        $model->paneer_remaining_total = $model->remaining_buffalo_paneer + $model->remaining_cow_paneer + $model->remaining_mixed_paneer;
    });
    static::deleted(function ($model) {
        $model->remaining_buffalo_paneer = $model->output_buffalo_paneer - $model->dispatch_buffalo_paneer;
        $model->remaining_cow_paneer = $model->output_cow_paneer - $model->dispatch_cow_paneer;
        $model->remaining_mixed_paneer = $model->output_mixed_paneer - $model->dispatch_mixed_paneer;
        $model->paneer_remaining_total = $model->remaining_buffalo_paneer + $model->remaining_cow_paneer + $model->remaining_mixed_paneer;
    });
   static::saving(function ($model) {
        $model->remaining_buffalo_paneer = $model->output_buffalo_paneer - $model->dispatch_buffalo_paneer;
        $model->remaining_cow_paneer = $model->output_cow_paneer - $model->dispatch_cow_paneer;
        $model->remaining_mixed_paneer = $model->output_mixed_paneer - $model->dispatch_mixed_paneer;
        $model->paneer_remaining_total = $model->remaining_buffalo_paneer + $model->remaining_cow_paneer + $model->remaining_mixed_paneer;
    });
  
    static::saved(function ($model) {
        $model->remaining_buffalo_paneer = $model->output_buffalo_paneer - $model->dispatch_buffalo_paneer;
        $model->remaining_cow_paneer = $model->output_cow_paneer - $model->dispatch_cow_paneer;
        $model->remaining_mixed_paneer = $model->output_mixed_paneer - $model->dispatch_mixed_paneer;
        $model->paneer_remaining_total = $model->remaining_buffalo_paneer + $model->remaining_cow_paneer + $model->remaining_mixed_paneer;
    });
}
}
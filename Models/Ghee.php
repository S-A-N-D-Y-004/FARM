<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ghee extends Model
{
    protected $fillable = [
        'date',
        'used_cow_cream',
        'used_buffalo_cream',
        'used_cow_butter',
        'used_buffalo_butter',
        'wastage_cow_cream',
        'wastage_buffalo_cream',
        'wastage_cow_butter',
        'wastage_buffalo_butter',
        'output_cow_ghee',
        'output_buffalo_ghee',
        'dispatch_cow_ghee',
        'dispatch_buffalo_ghee',
        'remaining_cow_ghee',
        'remaining_buffalo_ghee',
        'ghee_remaining_total',
        // Add any other fields you're using in the form

        
    ];
    public function butter()
{
    return $this->belongsTo(ButterModel::class, 'date', 'date');
}

public function butters()
{
    return $this->hasOne(ButterModel::class, 'date', 'date');
}

//     public function calculateRemainingGhee(array $data): array
// {
//     $data['remaining_cow_ghee'] = $data['output_cow_ghee'] - $data['dispatch_cow_ghee'];
//     $data['remaining_buffalo_ghee'] = $data['output_buffalo_ghee'] - $data['dispatch_buffalo_ghee'];

//     return $data;
// }

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->remaining_cow_ghee = $model->output_cow_ghee - $model->dispatch_cow_ghee;
        $model->remaining_buffalo_ghee = $model->output_buffalo_ghee - $model->dispatch_buffalo_ghee;
        $model->ghee_remaining_total = $model->remaining_cow_ghee + $model->remaining_buffalo_ghee;
    });

    static::updating(function ($model) {
        $model->remaining_cow_ghee = $model->output_cow_ghee - $model->dispatch_cow_ghee;
        $model->remaining_buffalo_ghee = $model->output_buffalo_ghee - $model->dispatch_buffalo_ghee;
        $model->ghee_remaining_total = $model->remaining_cow_ghee + $model->remaining_buffalo_ghee;
    });
    static::deleting(function ($model) {
        $model->remaining_cow_ghee = null;
        $model->remaining_buffalo_ghee = null;
        $model->ghee_remaining_total = null;
    });
    static::deleted(function ($model) {
        $model->remaining_cow_ghee = null;
        $model->remaining_buffalo_ghee = null;
        $model->ghee_remaining_total = null;
    });

    static::saving(function ($model) {
        $model->remaining_cow_ghee = $model->output_cow_ghee - $model->dispatch_cow_ghee;
        $model->remaining_buffalo_ghee = $model->output_buffalo_ghee - $model->dispatch_buffalo_ghee;
        $model->ghee_remaining_total = $model->remaining_cow_ghee + $model->remaining_buffalo_ghee;
    });
    static::saved(function ($model) {
        $model->remaining_cow_ghee = $model->output_cow_ghee - $model->dispatch_cow_ghee;
        $model->remaining_buffalo_ghee = $model->output_buffalo_ghee - $model->dispatch_buffalo_ghee;
        $model->ghee_remaining_total = $model->remaining_cow_ghee + $model->remaining_buffalo_ghee;
    });
}
}

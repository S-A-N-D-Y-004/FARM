<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurdReturn extends Model
{
    
        protected $fillable = [
            'date',
            'curd_standard_1kg',
            'curd_standard_5kg',
            'curd_standard_10kg',
            'curd_standard_total',
            'curd_double_1kg',
            'curd_double_5kg',
            'curd_double_10kg',
            'curd_double_total',
            'curd_toned_1kg',
            'curd_toned_5kg',
            'curd_toned_10kg',
            'curd_toned_total',
        ];

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->curd_standard_total = ($model->curd_standard_1kg * 1) + ($model->curd_standard_5kg * 5) + ($model->curd_standard_10kg * 10);
            $model->curd_double_total = ($model->curd_double_1kg * 1) + ($model->curd_double_5kg * 5) + ($model->curd_double_10kg * 10);
            $model->curd_toned_total = ($model->curd_toned_1kg * 1) + ($model->curd_toned_5kg * 5) + ($model->curd_toned_10kg * 10);
        });
        static::updating(function ($model) {
            $model->curd_standard_total = ($model->curd_standard_1kg * 1) + ($model->curd_standard_5kg * 5) + ($model->curd_standard_10kg * 10);
            $model->curd_double_total = ($model->curd_double_1kg * 1) + ($model->curd_double_5kg * 5) + ($model->curd_double_10kg * 10);
            $model->curd_toned_total = ($model->curd_toned_1kg * 1) + ($model->curd_toned_5kg * 5) + ($model->curd_toned_10kg * 10);
        });
        static::deleting(function ($model) {
            $model->curd_standard_total = ($model->curd_standard_1kg * 1) + ($model->curd_standard_5kg * 5) + ($model->curd_standard_10kg * 10);
            $model->curd_double_total = ($model->curd_double_1kg * 1) + ($model->curd_double_5kg * 5) + ($model->curd_double_10kg * 10);
            $model->curd_toned_total = ($model->curd_toned_1kg * 1) + ($model->curd_toned_5kg * 5) + ($model->curd_toned_10kg * 10);
        });
        static::saving(function ($model) {
            $model->curd_standard_total = ($model->curd_standard_1kg * 1) + ($model->curd_standard_5kg * 5) + ($model->curd_standard_10kg * 10);
            $model->curd_double_total = ($model->curd_double_1kg * 1) + ($model->curd_double_5kg * 5) + ($model->curd_double_10kg * 10);
            $model->curd_toned_total = ($model->curd_toned_1kg * 1) + ($model->curd_toned_5kg * 5) + ($model->curd_toned_10kg * 10);
        });
    }
    
}

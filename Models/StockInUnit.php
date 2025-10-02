<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'mixed_paneer',
        'buffalo_paneer',
        'cow_paneer',
        'total_paneer',

        'buffalo_cream',
        'cow_cream',
        'total_cream',

        'buffalo_ghee',
        'cow_ghee',
        'total_ghee',

        'buffalo_butter',
        'cow_butter',
        'total_butter',

        'stm_1kg',
        'stm_5kg',
        'stm_10kg',
        'total_stm',

        'tm_1kg',
        'tm_5kg',
        'tm_10kg',
        'total_tm',

        'dtm_1kg',
        'dtm_5kg',
        'dtm_10kg',
        'total_dtm',

        'buffalo_milk',
        'cow_milk',
        'total_milk',
    ];
}

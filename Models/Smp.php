<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smp extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'milk',
        'tm',
        'stm',
        'dtm',
        'total_smp',
        'added_smp',
        'remaining_stock',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Culture extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'tm',
        'stm',
        'dtm',
        'total_culture',
        'added_culture',
        'remaining_stock',
    ];

    protected $dates = ['date'];
}

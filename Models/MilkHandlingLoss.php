<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkHandlingLoss extends Model
{
    use HasFactory;

    protected $table = 'milk_handling_loss';

        protected $fillable = [
        'date',
        'buffalo_milk',
        'cow_milk',
        'remarks',
        ];
}

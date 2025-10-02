<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DgLogbook extends Model
{
    protected $table = '_dg_log';

    use HasFactory;
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'added_fuel',
    ];
}

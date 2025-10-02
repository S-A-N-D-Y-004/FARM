<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'particuler_id',
        'used_quantity',
        'added_quantity',
        'remaining_stock',
    ];


    public function particuler()
{
    return $this->belongsTo(Particuler::class);
}

}

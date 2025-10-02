<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YogurtDispatch extends Model
{
    use HasFactory;
    protected $table = 'yogurt_dispatch';
    protected $fillable = [
        'date',
        'one_kg',
        'five_kg',
        'ten_kg',
        'total_kg',
        'remaining_one_kg',
        'remaining_five_kg',
        'remaining_ten_kg',
        'remaining_total_kg'
    ];
    public function yogurt()
{
    return $this->belongsTo(Yogurt::class);
}

}

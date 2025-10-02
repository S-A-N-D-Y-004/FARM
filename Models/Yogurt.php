<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yogurt extends Model
{
    use HasFactory;
    protected $table = 'yogurt';
    protected $fillable = [
        'date',
        'fat_content',
        'buffalo_milk',
        'cow_milk',
        'one_kg',
        'five_kg',
        'ten_kg',
        'total_kg'
    ];
    public function dispatches()
{
    return $this->hasMany(YogurtDispatch::class);
}

}

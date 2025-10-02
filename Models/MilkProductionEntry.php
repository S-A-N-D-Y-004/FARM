<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkProductionEntry extends Model
{
    use HasFactory;
    protected $fillable = ['milk_production_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function milkProduction()
    {
        return $this->belongsTo(MilkProduction::class);
    }
}

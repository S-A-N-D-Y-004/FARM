<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milkproduction extends Model
{
    use HasFactory;


    protected $table = 'milk_production';

    protected $fillable = [
        'date',
        'product_name',
        'buffalo_milk_for_kims',
        'cow_milk_for_kims',
        'buffalo_milk_other_products',
        'total_buffalo_milk',
        'total_cow_milk',
        'total_product_milk',
        'buffalo_milk_fresh',
        'buffalo_milk_fresh_homo',
        'buffalo_milk_creamy',
        'buffalo_milk_a2'
    ];
    public function entries()
    {
        return $this->hasMany(MilkProductionEntry::class, 'milk_production_id');
    }

    
    /**
     * Calculate total buffalo and cow milk from entries.
     */
    public function calculateAndSetTotals($entries = null)
{
    $buffaloTotal = 0;
    $cowTotal = 0;

    // This is key 👇 — fallback must include product
    $entries = $entries ?? $this->entries()->with('product')->get();

    foreach ($entries as $entry) {
        if ($entry->product && $entry->product->type === 'buffalo') {
            $buffaloTotal += $entry->quantity ?? 0;
        } elseif ($entry->product && $entry->product->type === 'cow') {
            $cowTotal += $entry->quantity ?? 0;
        }
    }

    $this->total_buffalo_milk = $buffaloTotal;
    $this->total_cow_milk = $cowTotal;
}

    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($milkProduction) {
            $milkProduction->calculateAndSetTotals();
        });
    
        static::updating(function ($milkProduction) {
            $milkProduction->calculateAndSetTotals();
        });

        static::deleting(function ($milkProduction) {
            $milkProduction->calculateAndSetTotals();
        });
        
        static::saving(function ($milkProduction) {
            $milkProduction->calculateAndSetTotals();
        });
    }
    
}

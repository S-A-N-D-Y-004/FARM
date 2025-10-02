<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnMilk extends Model
{
    use HasFactory;
    protected $table = 'return_milk';
    protected $fillable = [
        'date'
    ];
    public function entries() {
        return $this->hasMany(ReturnMilkEntry::class);
    }
    public function returnMilk()
{
    return $this->belongsTo(ReturnMilk::class);
}

public function calculateAndSetTotals($entries = null)
{
    $buffaloTotal = 0;
    $cowTotal = 0;

    $entries = $entries ?? $this->entries()->with('product')->get();

    foreach ($entries as $entry) {
        if ($entry->product->type === 'buffalo') {
            $buffaloTotal += $entry->quantity ?? 0;
        } elseif ($entry->product->type === 'cow') {
            $cowTotal += $entry->quantity ?? 0;
        }
    }

    $this->total_buffalo_milk = $buffaloTotal;
    $this->total_cow_milk = $cowTotal;
}

}


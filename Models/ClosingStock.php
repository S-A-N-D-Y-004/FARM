<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosingStock extends Model
{
    use HasFactory;
protected $table = 'closing_stock';
    protected $fillable = [
        'date',
        'raw_buffalo_milk', 'raw_cow_milk', 'return_buffalo_milk',
        'return_cow_milk', 'total_buffalo_milk', 'total_cow_milk',
        'dispatched_buffalo_milk', 'dispatched_cow_milk', 'used_buffalo_milk',
        'used_cow_milk', 'remaining_buffalo_milk', 'remaining_cow_milk',
    ];

    protected static function booted()
    {
        static::saving(function ($closingstock) {
            // Ensure these variables are properly defined or fetched
            $rawmilk = $closingstock->rawmilk ?? (object) ['total_buffalo' => 0, 'total_cow' => 0];
            $milkcustomers = $closingstock->milkcustomers ?? (object) ['buffalo_milk' => 0, 'cow_milk' => 0];
            $cream = $closingstock->cream ?? (object) ['used_buffalo_milk' => 0, 'used_cow_milk' => 0];
            $paneer = $closingstock->paneer ?? (object) ['buffalo_milk' => 0, 'cow_milk' => 0];

            // Calculate fields
            $closingstock->raw_buffalo_milk = $rawmilk->total_buffalo;
            $closingstock->raw_cow_milk = $rawmilk->total_cow;

            $closingstock->dispatched_buffalo_milk = $milkcustomers->buffalo_milk;
            $closingstock->dispatched_cow_milk = $milkcustomers->cow_milk;

            $closingstock->used_buffalo_milk = $cream->used_buffalo_milk + $paneer->buffalo_milk;
            $closingstock->used_cow_milk = $cream->used_cow_milk + $paneer->cow_milk;

            $closingstock->remaining_buffalo_milk = $closingstock->raw_buffalo_milk 
                - $closingstock->dispatched_buffalo_milk 
                - $closingstock->used_buffalo_milk;

            $closingstock->remaining_cow_milk = $closingstock->raw_cow_milk 
                - $closingstock->dispatched_cow_milk 
                - $closingstock->used_cow_milk;
        });
    }
}
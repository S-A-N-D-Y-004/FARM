<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkForCustomer extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['customer_id', 'date', 'buffalo_milk', 'cow_milk','total_buffalo_milk', 'total_cow_milk',];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

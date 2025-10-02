<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnMilkEntry extends Model
{
    use HasFactory;
    protected $fillable = ['return_milk_id', 'product_id', 'quantity'];

    public function returnMilk() {
        return $this->belongsTo(ReturnMilk::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}

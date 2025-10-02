<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurdforCustomer extends Model
{
    use HasFactory;

    protected $table = 'curd_for_customers';
    protected $fillable = [
        'date',
        'customer_id',
        'tm_1kg',
        'tm_5kg',
        'tm_10kg',
        'stm_1kg',
        'stm_5kg',
        'stm_10kg',
        'dtm_1kg',
        'dtm_5kg',
        'dtm_10kg',
    ];

       public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

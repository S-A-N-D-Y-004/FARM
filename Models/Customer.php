<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function milkForCustomers()
    {
        return $this->hasMany(MilkForCustomer::class);
    }
    public function curdForCustomers(){
        return $this->hasMany(CurdforCustomer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'location', 
        'address', 
        'phone', 
        'email'
    ];
    public function milkstorage()
    {
        return $this->hasOne(MilkStorage::class);
    }
    public function milkStorages()
{
    return $this->hasMany(MilkStorage::class);
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkStorage extends Model
{
    use HasFactory;
    protected $table = 'milk_storage';

    protected $fillable = [
        'date', 'vendor_id',
        'litres_am_buffalo', 'litres_am_cow', 'litres_pm_buffalo', 'litres_pm_cow',
        'fat_am_buffalo', 'fat_am_cow', 'fat_pm_buffalo', 'fat_pm_cow',
        'snf_am_buffalo', 'snf_am_cow', 'snf_pm_buffalo', 'snf_pm_cow',
        'water_am_buffalo', 'water_am_cow', 'water_pm_buffalo', 'water_pm_cow',
        'remarks', 'total_buffalo', 'total_cow'
    ];
    public static function boot()
    {
        parent::boot();

        static::saving(function ($milkStorage) {
            $milkStorage->total_buffalo = ($milkStorage->litres_am_buffalo ?? 0) + ($milkStorage->litres_pm_buffalo ?? 0);
            $milkStorage->total_cow = ($milkStorage->litres_am_cow ?? 0) + ($milkStorage->litres_pm_cow ?? 0);
        });
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function getTotalBuffaloAttribute()
    {
        return ($this->litres_am_buffalo ?? 0) + ($this->litres_pm_buffalo ?? 0);
    }

    // Total Cow Milk (AM + PM)
    public function getTotalCowAttribute()
    {
        return ($this->litres_am_cow ?? 0) + ($this->litres_pm_cow ?? 0);
    }
    //   public function vendor()
    // {
    //     return $this->hasOne(Vendor::class);
    // }
}

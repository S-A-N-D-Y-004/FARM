<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curdbatch extends Model
{
    use HasFactory;
    protected $table = 'curdbatch';

    protected $fillable = [
        'date',
        'name',

        // TM fields
        'tm_whole_buffalo_milk',
        'tm_skimmed_buffalo_milk',
        'tm_total_buffalo_milk',
        'tm_total_cow_milk',
        'tm_skimmed_cow_milk',
        'tm_skimmed_milk_provider',
        'tm_one_kg',
        'tm_five_kg',
        'tm_ten_kg',
        'tm_culture',

        // STM fields
        'stm_whole_buffalo_milk',
        'stm_skimmed_buffalo_milk',
        'stm_total_buffalo_milk',
        'stm_total_cow_milk',
        'stm_skimmed_cow_milk',
        'stm_skimmed_milk_provider',
        'stm_one_kg',
        'stm_five_kg',
        'stm_ten_kg',
        'stm_culture',

        // DTM fields
        'dtm_whole_buffalo_milk',
        'dtm_skimmed_buffalo_milk',
        'dtm_total_buffalo_milk',
        'dtm_total_cow_milk',
        'dtm_skimmed_cow_milk',
        'dtm_skimmed_milk_provider',
        'dtm_one_kg',
        'dtm_five_kg',
        'dtm_ten_kg',
        'dtm_culture',
    ];



    public function curdbatchName()
    {
        return $this->belongsTo(CurdbatchName::class, 'name');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->tm_total = ($model->tm_one_kg * 1) + ($model->tm_five_kg * 5) + ($model->tm_ten_kg * 10);
            $model->stm_total = ($model->stm_one_kg * 1) + ($model->stm_five_kg * 5) + ($model->stm_ten_kg * 10);
            $model->dtm_total = ($model->dtm_one_kg * 1) + ($model->dtm_five_kg * 5) + ($model->dtm_ten_kg * 10);
        });
        static::updating(function ($model) {
            $model->tm_total = ($model->tm_one_kg * 1) + ($model->tm_five_kg * 5) + ($model->tm_ten_kg * 10);
            $model->stm_total = ($model->stm_one_kg * 1) + ($model->stm_five_kg * 5) + ($model->stm_ten_kg * 10);
            $model->dtm_total = ($model->dtm_one_kg * 1) + ($model->dtm_five_kg * 5) + ($model->dtm_ten_kg * 10);
        });
        static::deleting(function ($model) {
            $model->tm_total = ($model->tm_one_kg * 1) + ($model->tm_five_kg * 5) + ($model->tm_ten_kg * 10);
            $model->stm_total = ($model->stm_one_kg * 1) + ($model->stm_five_kg * 5) + ($model->stm_ten_kg * 10);
            $model->dtm_total = ($model->dtm_one_kg * 1) + ($model->dtm_five_kg * 5) + ($model->dtm_ten_kg * 10);
        });
        static::saving(function ($model) {
            $model->tm_total = ($model->tm_one_kg * 1) + ($model->tm_five_kg * 5) + ($model->tm_ten_kg * 10);
            $model->stm_total = ($model->stm_one_kg * 1) + ($model->stm_five_kg * 5) + ($model->stm_ten_kg * 10);
            $model->dtm_total = ($model->dtm_one_kg * 1) + ($model->dtm_five_kg * 5) + ($model->dtm_ten_kg * 10);
        });

        static::creating(function ($model) {
            $model->tm_total_buffalo_milk = ($model->tm_whole_buffalo_milk)  + ($model->tm_skimmed_buffalo_milk);
            $model->stm_total_buffalo_milk = ($model->stm_whole_buffalo_milk)  + ($model->stm_skimmed_buffalo_milk);
            $model->dtm_total_buffalo_milk = ($model->dtm_whole_buffalo_milk)  + ($model->dtm_skimmed_buffalo_milk);
            $model->tm_total_cow_milk = ($model->tm_skimmed_cow_milk);
            $model->stm_total_cow_milk = ($model->stm_skimmed_cow_milk);
            $model->dtm_total_cow_milk = ($model->dtm_skimmed_cow_milk);
        });
        static::updating(function ($model) {
            $model->tm_total_buffalo_milk = ($model->tm_whole_buffalo_milk)  + ($model->tm_skimmed_buffalo_milk);
            $model->stm_total_buffalo_milk = ($model->stm_whole_buffalo_milk)  + ($model->stm_skimmed_buffalo_milk);
            $model->dtm_total_buffalo_milk = ($model->dtm_whole_buffalo_milk)  + ($model->dtm_skimmed_buffalo_milk);
            $model->tm_total_cow_milk = ($model->tm_skimmed_cow_milk);
            $model->stm_total_cow_milk = ($model->stm_skimmed_cow_milk);
            $model->dtm_total_cow_milk = ($model->dtm_skimmed_cow_milk);
        });
        static::deleting(function ($model) {
            $model->tm_total_buffalo_milk = ($model->tm_whole_buffalo_milk)  + ($model->tm_skimmed_buffalo_milk);
            $model->stm_total_buffalo_milk = ($model->stm_whole_buffalo_milk)  + ($model->stm_skimmed_buffalo_milk);
            $model->dtm_total_buffalo_milk = ($model->dtm_whole_buffalo_milk)  + ($model->dtm_skimmed_buffalo_milk);
            $model->tm_total_cow_milk = ($model->tm_skimmed_cow_milk);
            $model->stm_total_cow_milk = ($model->stm_skimmed_cow_milk);
            $model->dtm_total_cow_milk = ($model->dtm_skimmed_cow_milk);
        });
        static::saving(function ($model) {
            $model->tm_total_buffalo_milk = ($model->tm_whole_buffalo_milk)  + ($model->tm_skimmed_buffalo_milk);
            $model->stm_total_buffalo_milk = ($model->stm_whole_buffalo_milk)  + ($model->stm_skimmed_buffalo_milk);
            $model->dtm_total_buffalo_milk = ($model->dtm_whole_buffalo_milk)  + ($model->dtm_skimmed_buffalo_milk);
            $model->tm_total_cow_milk = ($model->tm_skimmed_cow_milk);
            $model->stm_total_cow_milk = ($model->stm_skimmed_cow_milk);
            $model->dtm_total_cow_milk = ($model->dtm_skimmed_cow_milk);
        });
    }

// app/Models/Curdbatch.php

protected static function booted()
{
    static::saved(function ($curdbatch) {
        $date = \Carbon\Carbon::parse($curdbatch->date)->format('Y-m-d');

        // ✅ Common curds fetch
        $curds = self::whereDate('date', $date)->get();

        // ✅ CULTURE calculation
        $tm_culture = $curds->sum('tm_culture');
        $stm_culture = $curds->sum('stm_culture');
        $dtm_culture = $curds->sum('dtm_culture');
        $total_culture = $tm_culture + $stm_culture + $dtm_culture;

        \App\Models\Culture::updateOrCreate(
            ['date' => $date],
            [
                'tm' => $tm_culture,
                'stm' => $stm_culture,
                'dtm' => $dtm_culture,
                'total_culture' => $total_culture,
            ]
        );

        // ✅ SMP calculation
        $tm_smp = $curds->sum('tm_skimmed_milk_provider');
        $stm_smp = $curds->sum('stm_skimmed_milk_provider');
        $dtm_smp = $curds->sum('dtm_skimmed_milk_provider');
        $total_smp = $tm_smp + $stm_smp + $dtm_smp;

        \App\Models\Smp::updateOrCreate(
            ['date' => $date],
            [
                'tm' => $tm_smp,
                'stm' => $stm_smp,
                'dtm' => $dtm_smp,
                'total_smp' => $total_smp,
            ]
        );
    });
}


}

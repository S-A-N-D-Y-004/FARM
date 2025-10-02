<?php

namespace App\Helpers;

class MilkHelper
{
    public static function getRemainingMilk($summary, $production, $paneer, $cream, $curd, $milkforcustomer, $milkreturns)
    {
        return [
            'buffalo' => ($summary->total_buffalo ?? 0)
                        - ($production->total_buffalo_milk ?? 0)
                        - ($paneer->buffalo_milk ?? 0)
                        - ($cream->used_buffalo_milk ?? 0)
                        - ($curd->total_buffalo_milk ?? 0)
                        - ($milkforcustomer->buffalo_milk ?? 0)
                        + ($milkreturns->total_buffalo_milk ?? 0),

            'cow' => ($summary->total_cow ?? 0)
                        - ($production->total_cow_milk ?? 0)
                        - ($paneer->cow_milk ?? 0)
                        - ($cream->used_cow_milk ?? 0)
                        - ($curd->total_cow_milk ?? 0)
                        - ($milkforcustomer->cow_milk ?? 0)
                        + ($milkreturns->total_cow_milk ?? 0),
        ];
    }
}

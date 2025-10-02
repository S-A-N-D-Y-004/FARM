<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Observers\ButterObserver;
use App\Observers\GheeObserver;
use App\Models\ButterModel;
use App\Models\Ghee;
use App\Models\Curdbatch;
use App\Observers\CurdBatchObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ButterModel::observe(ButterObserver::class);
        Ghee::observe(GheeObserver::class);
        CurdBatch::observe(CurdBatchObserver::class);
    }
}

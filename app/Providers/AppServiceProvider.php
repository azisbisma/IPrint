<?php

namespace App\Providers;

use App\Models\Product;
use Carbon\Carbon;
use App\Observers\ProductObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Product::observe(ProductObserver::class);
        Carbon::setLocale('id');
    }
}

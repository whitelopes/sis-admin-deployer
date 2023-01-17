<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        \App\Models\MovimentosEstoque::observe(\App\Observers\MovimentosEstoqueObserver::class);
        \App\Models\MovimentosFinanceiro::observe(\App\Observers\MovimentosFinanceiroObserver::class);
    }
}

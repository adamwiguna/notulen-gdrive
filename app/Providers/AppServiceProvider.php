<?php

namespace App\Providers;


use ConsoleTVs\Charts\Registrar as Charts;
use App\Charts\SampleChart;
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
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\SampleChart::class,
            \App\Charts\NotulenChart::class,
            \App\Charts\PieChart::class,
            \App\Charts\NotulenPerOrganization::class,
        ]);
    }
}

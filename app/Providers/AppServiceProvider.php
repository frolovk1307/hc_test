<?php

namespace App\Providers;

use App\Services\DestinationSearch\DestinationsRepository;
use App\Services\DestinationSearch\FileRepository;
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
        $this->app->bind(DestinationsRepository::class, FileRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

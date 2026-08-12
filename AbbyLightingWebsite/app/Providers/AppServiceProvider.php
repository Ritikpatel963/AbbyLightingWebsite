<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        if(config('custom_config.FORCE_HTTPS')) { 
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        view()->share(
            'catalogDownloadForm', url('catalog-download-user-form')
        );
    }
}

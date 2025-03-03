<?php

namespace App\Providers;

use Encore\Admin\Facades\Admin;
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
    public function boot()
    {
        // In your ServiceProvider, add this to the boot method
        
    Admin::style(file_get_contents(public_path('css/admin-custom.css')));
    }
}

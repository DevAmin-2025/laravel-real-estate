<?php

namespace App\Providers;

use App\Models\Footer;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFour();

        View::composer('front.layouts.footer', function ($view) {
            $view->with(['footer' => Footer::first()]);
        });

        View::share('setting', Setting::first());
    }
}

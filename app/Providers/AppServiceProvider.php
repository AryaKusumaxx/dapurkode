<?php

namespace App\Providers;

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
        \Illuminate\Pagination\Paginator::useTailwind();
        
        // Register Blade Components
        \Illuminate\Support\Facades\Blade::component('order-status', \App\View\Components\OrderStatus::class);
        \Illuminate\Support\Facades\Blade::component('admin-layout-with-tinymce', \App\View\Components\AdminLayoutWithTinymce::class);
    }
}

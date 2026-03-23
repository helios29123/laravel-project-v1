<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        // Chia sẻ dữ liệu danh mục cho header layout (layout dùng chung ở mọi màn hình)
        View::composer('layouts.header', function ($view) {
            $globalCategories = Category::all();
            $view->with('globalCategories', $globalCategories);
        });
    }
}

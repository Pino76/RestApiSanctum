<?php

namespace App\Providers;

use App\Repository\CategoryRepository;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Services\CategoryService;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);

        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

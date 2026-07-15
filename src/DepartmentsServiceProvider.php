<?php

namespace Agriserv\Departments;

use Agriserv\Departments\Http\Middleware\VerifySecretToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DepartmentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/departments.php', 'departments');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/departments.php' => config_path('departments.php'),
            ], 'departments-config');
        }

        Route::middleware(['api', VerifySecretToken::class])
            ->post('api/departments/sync', config('departments.controller'))
            ->name('departments.sync');
    }
}

<?php

namespace App\Providers;

use App\Services\AI\AnalistaService;
use App\Services\AI\Contracts\AnalistaInterface;
use App\Services\AI\Contracts\FiscalInterface;
use App\Services\AI\Contracts\JuridicaInterface;
use App\Services\AI\FiscalService;
use App\Services\AI\JuridicaService;
use Illuminate\Support\ServiceProvider;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AnalistaInterface::class, function ($app) {
            return new AnalistaService();
        });

        $this->app->singleton(FiscalInterface::class, function ($app) {
            return new FiscalService();
        });

        $this->app->singleton(JuridicaInterface::class, function ($app) {
            return new JuridicaService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
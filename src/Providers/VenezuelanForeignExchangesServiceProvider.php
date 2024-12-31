<?php

namespace Laymont\VenezuelanForeignExchanges\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laymont\VenezuelanForeignExchanges\Concerns\BcvCurrencies;
use Laymont\VenezuelanForeignExchanges\Services\BcvService;
class VenezuelanForeignExchangesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BcvCurrencies::class, function ($app) {
            return new BcvCurrencies();
        });
        $this->app->bind(BcvService::class, function ($app) {
            return new BcvService($app->make(BcvCurrencies::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/bcv.php' => config_path('bcv.php'),
            ], 'config');
        }
        $this->registerRoutes();
    }

    /**
     * @return void
     */
    protected function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    /**
     * @return string[]
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => '',
        ];
    }
}

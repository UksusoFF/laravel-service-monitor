<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\AppController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->enforceUrlScheme();

        $this->registerRoutes();
    }

    protected function enforceUrlScheme(): void
    {
        $url = config('app.url');

        if (!Str::startsWith($url, 'https://')) {
            return;
        }

        URL::forceRootUrl($url);
        URL::forceScheme('https');
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function(Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }

    protected function registerRoutes(): void
    {
        Route::group([
            'middleware' => ['api'],
            'prefix' => 'api',
        ], function() {
            Route::group([
                'prefix' => 'data',
            ], function() {
                //
            });
        });

        Route::group([
            'middleware' => ['web'],
        ], function() {
            Route::get('{any?}', [AppController::class, 'app'])->where('any', '.*');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('backend/api')
                ->middleware('api','cors','localization','date_format','currency','timezone','settings')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
                Route::prefix('backend/api')
                ->middleware('api','cors','localization','date_format','currency','timezone','settings')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin-route.php'));
                Route::prefix('backend/api')
                ->middleware('api','cors','localization','date_format','currency','timezone','settings')
                ->namespace($this->namespace)
                ->group(base_path('routes/vendor-route.php'));
                Route::prefix('backend/api')
                ->middleware('api','cors','localization','date_format','currency','timezone','settings')
                ->namespace($this->namespace)
                ->group(base_path('routes/auth-route.php'));
            Route::prefix('backend/api')
                ->middleware('cors','localization','date_format','currency','timezone','settings')
                ->namespace($this->namespace)
                ->group(base_path('routes/media.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
        Route::macro('adminRoutes', function ($uri, $controller,$prefix = null) {
            Route::post("{$uri}/export", "{$controller}@export");
            // Route::post("{$uri}/export", "{$controller}@export")->name("{$uri}.export");
            $singular =Str::of($uri)->singular();
            // Route::put("{$uri}/updateStatus/{{$singular}}", "{$controller}@updateStatus")->name("{$uri}.update_status");
            Route::put("{$uri}/updateStatus/{{$singular}}", "{$controller}@updateStatus");
            // Route::post("{$uri}/filter", "{$controller}@filter")->name("{$uri}.filter");
            Route::post("{$uri}/filter", "{$controller}@filter");
            Route::apiResource($uri, $controller,['as' => $prefix]);
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}

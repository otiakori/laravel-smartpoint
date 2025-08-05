<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // @can directive
        Blade::directive('can', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasPermission({$expression})): ?>";
        });

        Blade::directive('endcan', function () {
            return "<?php endif; ?>";
        });

        // @cannot directive
        Blade::directive('cannot', function ($expression) {
            return "<?php if (!Auth::check() || !Auth::user()->hasPermission({$expression})): ?>";
        });

        Blade::directive('endcannot', function () {
            return "<?php endif; ?>";
        });

        // @role directive
        Blade::directive('role', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasRole({$expression})): ?>";
        });

        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });

        // @anyrole directive
        Blade::directive('anyrole', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasAnyRole({$expression})): ?>";
        });

        Blade::directive('endanyrole', function () {
            return "<?php endif; ?>";
        });

        // @hasanypermission directive
        Blade::directive('hasanypermission', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasAnyPermission({$expression})): ?>";
        });

        Blade::directive('endhasanypermission', function () {
            return "<?php endif; ?>";
        });

        // @hasallpermissions directive
        Blade::directive('hasallpermissions', function ($expression) {
            return "<?php if (Auth::check() && Auth::user()->hasAllPermissions({$expression})): ?>";
        });

        Blade::directive('endhasallpermissions', function () {
            return "<?php endif; ?>";
        });
    }
}

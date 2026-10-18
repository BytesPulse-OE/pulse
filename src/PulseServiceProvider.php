<?php

declare(strict_types=1);

namespace BytespulseOe\Pulse;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class PulseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::anonymousComponentPath(
            dirname(__DIR__).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'pulse',
            'pulse',
        );

        // Blade::anonymousComponentPath() always appends, so a consuming
        // app's override (registered after ours) would be checked LAST,
        // never winning over our own view of the same component. We
        // prepend it directly onto the same namespace instead, so the
        // app's view is checked first and falls back to ours only when it
        // doesn't have one.
        if (function_exists('resource_path')) {
            $overridePath = resource_path('views'.DIRECTORY_SEPARATOR.'pulse');

            if (is_dir($overridePath)) {
                View::prependNamespace(
                    app()->version() >= 12 ? hash('xxh128', 'pulse') : md5('pulse'),
                    $overridePath,
                );
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

use Illuminate\Support\ServiceProvider;

/**
 * This is the CommonMark useful extension service provider class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class UsefulCommonMarkExtensionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [];
    }
}

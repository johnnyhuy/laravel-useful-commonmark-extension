<?php

declare(strict_types=1);

/*
 * This file is part of Alt Three Emoji.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JohnnyHuy\Laravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use JohnnyHuy\Laravel\Block\Parser\TextAlignmentParser;
use JohnnyHuy\Laravel\Inline\Parser\SoundCloudParser;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;

/**
 * This is the CommonMark useful extension service provider class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class UsefulCommonMarkExtensionServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__.'/../config/emoji.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('emoji.php')]);
        }

        $this->mergeConfigFrom($source, 'emoji');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerParser();
    }

    /**
     * Register the parser class.
     *
     * @return void
     */
    protected function registerParser()
    {
        $this->app->singleton(YouTubeParser::class, function () { return new YouTubeParser(); });
        $this->app->singleton(SoundCloudParser::class, function () { return new SoundCloudParser(); });
        $this->app->singleton(TextAlignmentParser::class, function () { return new TextAlignmentParser(); });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            //
        ];
    }
}

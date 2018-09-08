<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

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

<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

use Illuminate\Support\ServiceProvider;
use JohnnyHuy\Laravel\Inline\Parser\CodepenParser;
use JohnnyHuy\Laravel\Inline\Parser\GistParser;
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
        $this->app->singleton(GistParser::class, function () { return new GistParser(); });
        $this->app->singleton(CodepenParser::class, function () { return new CodepenParser(); });
        $this->app->singleton(YouTubeParser::class, function () { return new YouTubeParser(); });
        $this->app->singleton(SoundCloudParser::class, function () { return new SoundCloudParser(); });
        $this->app->singleton(Block\Parser\ColorParser::class, function () { return new Block\Parser\ColorParser(); });
        $this->app->singleton(Inline\Parser\OpenColorParser::class, function () { return new Inline\Parser\OpenColorParser(); });
        $this->app->singleton(Inline\Parser\CloseColorParser::class, function () { return new Inline\Parser\CloseColorParser(); });
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

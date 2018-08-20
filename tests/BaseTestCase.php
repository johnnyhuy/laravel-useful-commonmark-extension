<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests;

use GrahamCampbell\Markdown\MarkdownServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;
use JohnnyHuy\Laravel\MarkdownExtension;
use JohnnyHuy\Laravel\MarkdownExtensionServiceProvider;

class BaseTestCase extends AbstractPackageTestCase
{
    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app->config->set('markdown.extensions', [MarkdownExtension::class]);
    }

    /**
     * Get the required service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getRequiredServiceProviders($app)
    {
        return [MarkdownServiceProvider::class];
    }

    /**
     * Get the service provider class.
     *
     * @param string $app
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return MarkdownExtensionServiceProvider::class;
    }
}
<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Laravel;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use JohnnyHuy\Laravel\Block\Parser\ColorParser;
use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use JohnnyHuy\Laravel\UsefulCommonMarkExtension;
use League\CommonMark\Environment;

/**
 * CommonMark Laravel service provider tests
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class ServiceProviderTest extends BaseTestCase
{
    use LaravelTrait;
    use ServiceProviderTrait;

    public function testMarkdownParserIsInjectable()
    {
        $this->assertIsInjectable(ColorParser::class);
    }

    public function testMarkdownExtensionIsInjectable()
    {
        $this->assertIsInjectable(UsefulCommonMarkExtension::class);
    }

    public function testExtensionIsInstalled()
    {
        $this->assertTrue(in_array(new UsefulCommonMarkExtension($this->app), $this->app->get(Environment::class)->getExtensions()));
    }

    public function testInjectParsers()
    {
        /** @var Environment $environment */
        $environment = $this->app->get(Environment::class);

        // Act
        $extension = $environment->getExtensions()[1];

        // Assert
        $this->assertTrue($extension instanceof UsefulCommonMarkExtension);
        $this->assertTrue(is_object($extension));
        $this->assertTrue(in_array(resolve(ColorParser::class), $extension->blockParsers, false));
    }
}

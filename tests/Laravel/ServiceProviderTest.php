<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Laravel;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use JohnnyHuy\Laravel\Block\Parser\ColorParser;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;
use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use JohnnyHuy\Laravel\Inline\Parser\GistParser;
use JohnnyHuy\Laravel\Inline\Parser\CodepenParser;
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
        $this->assertIsInjectable(YouTubeParser::class);
        $this->assertIsInjectable(GistParser::class);
        $this->assertIsInjectable(CodepenParser::class);
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

        $this->assertTrue(in_array(resolve(YouTubeParser::class), $environment->getInlineParsers(), true));
        $this->assertTrue(in_array(resolve(GistParser::class), $environment->getInlineParsers(), true));
        $this->assertTrue(in_array(resolve(CodepenParser::class), $environment->getInlineParsers(), true));
        $this->assertTrue(in_array(resolve(ColorParser::class), $environment->getBlockParsers(), true));
    }
}

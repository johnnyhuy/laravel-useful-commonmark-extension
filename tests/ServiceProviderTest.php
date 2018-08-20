<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;
use JohnnyHuy\Laravel\MarkdownExtension;
use League\CommonMark\Environment;

class ServiceProviderTest extends BaseTestCase
{
    use LaravelTrait;
    use ServiceProviderTrait;

    public function testMarkdownParserIsInjectable()
    {
        $this->assertIsInjectable(YouTubeParser::class);
    }

    public function testMarkdownExtensionIsInjectable()
    {
        $this->assertIsInjectable(MarkdownExtension::class);
    }

    public function testEnvironmentIsSetup()
    {
        $this->assertTrue(in_array(resolve(YouTubeParser::class), resolve(Environment::class)->getInlineParsers(), true));
    }
}

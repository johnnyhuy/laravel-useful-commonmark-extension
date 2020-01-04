<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

use JohnnyHuy\Laravel\Inline\Element\Gist;
use JohnnyHuy\Laravel\Inline\Element\Codepen;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use JohnnyHuy\Laravel\Block\Element\BlockColor;
use JohnnyHuy\Laravel\Block\Parser\ColorParser;
use JohnnyHuy\Laravel\Inline\Parser\GistParser;
use League\CommonMark\Block\Element\FencedCode;
use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use JohnnyHuy\Laravel\Inline\Element\InlineColor;
use League\CommonMark\Block\Element\IndentedCode;
use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use JohnnyHuy\Laravel\Inline\Parser\CodepenParser;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;
use JohnnyHuy\Laravel\Inline\Renderer\GistRenderer;
use League\CommonMark\Extension\ExtensionInterface;
use JohnnyHuy\Laravel\Inline\Parser\OpenColorParser;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use JohnnyHuy\Laravel\Inline\Parser\CloseColorParser;
use JohnnyHuy\Laravel\Inline\Parser\SoundCloudParser;
use JohnnyHuy\Laravel\Inline\Renderer\CodepenRenderer;
use JohnnyHuy\Laravel\Inline\Renderer\YouTubeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use JohnnyHuy\Laravel\Block\Parser\TextAlignmentParser;
use League\CommonMark\ConfigurableEnvironmentInterface;
use JohnnyHuy\Laravel\Block\Renderer\ColorBlockRenderer;
use JohnnyHuy\Laravel\Inline\Renderer\SoundCloudRenderer;
use JohnnyHuy\Laravel\Inline\Renderer\ColorInlineRenderer;
use JohnnyHuy\Laravel\Block\Renderer\TextAlignmentRenderer;

/**
 * This is the useful CommonMark extension class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class UsefulCommonMarkExtension implements ExtensionInterface
{
    /**
     * Register the actual extensions to the framework.
     *
     * @param ConfigurableEnvironmentInterface $environment
     */
    public function register(ConfigurableEnvironmentInterface $environment): void
    {
        $environment->addBlockParser(new TextAlignmentParser());
        $environment->addBlockParser(new ColorParser());

        $environment->addBlockRenderer(TextAlignment::class, new TextAlignmentRenderer());
        $environment->addBlockRenderer(BlockColor::class, new ColorBlockRenderer());
        $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer(['html', 'php', 'js', 'lua', 'python', 'go']), 10);
        $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer(['html', 'php', 'js', 'lua', 'python', 'go']), 10);

        $environment->addInlineParser(new GistParser());
        $environment->addInlineParser(new CodepenParser());
        $environment->addInlineParser(new YouTubeParser());
        $environment->addInlineParser(new SoundCloudParser());
        $environment->addInlineParser(new OpenColorParser());
        $environment->addInlineParser(new CloseColorParser());

        $environment->addInlineRenderer(Gist::class, new GistRenderer());
        $environment->addInlineRenderer(Codepen::class, new CodepenRenderer());
        $environment->addInlineRenderer(YouTube::class, new YouTubeRenderer());
        $environment->addInlineRenderer(SoundCloud::class, new SoundCloudRenderer());
        $environment->addInlineRenderer(InlineColor::class, new ColorInlineRenderer());
    }
}

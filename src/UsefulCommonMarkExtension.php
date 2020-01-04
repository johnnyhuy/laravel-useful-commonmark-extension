<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

use JohnnyHuy\Laravel\Inline\Element\Gist;
use Illuminate\Contracts\Container\Container;
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
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * This is the useful CommonMark extension class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class UsefulCommonMarkExtension implements ExtensionInterface
{
    /**
     * @var array
     */
    public $inlineParsers;

    /**
     * @var array
     */
    public $inlineRenderers;

    /**
     * @var array
     */
    public $blockParsers;

    /**
     * @var array
     */
    public $blockRenderers;

    /**
     * Create the instances here for Laravel container injection.
     * This is needed to allow Laravel to inject dependencies.
     *
     * @param Container $container
     * @throws BindingResolutionException
     */
    public function __construct(Container $container)
    {
        $this->inlineParsers = [
            $container->make(GistParser::class),
            $container->make(CodepenParser::class),
            $container->make(YouTubeParser::class),
            $container->make(SoundCloudParser::class),
            $container->make(OpenColorParser::class),
            $container->make(CloseColorParser::class),
        ];

        $this->inlineRenderers = [
            Gist::class => $container->make(GistRenderer::class),
            Codepen::class => $container->make(CodepenRenderer::class),
            YouTube::class => $container->make(YouTubeRenderer::class),
            SoundCloud::class => $container->make(SoundCloudRenderer::class),
            InlineColor::class => $container->make(ColorInlineRenderer::class)
        ];

        $this->blockParsers = [
            $container->make(TextAlignmentParser::class),
            $container->make(ColorParser::class),
        ];

        $this->blockRenderers = [
            TextAlignment::class => $container->make(TextAlignmentRenderer::class),
            BlockColor::class => $container->make(ColorBlockRenderer::class),
            FencedCode::class => $container->make(FencedCodeRenderer::class),
            IndentedCode::class => $container->make(IndentedCodeRenderer::class),
        ];
    }

    /**
     * Register the actual extensions to the framework.
     *
     * @param ConfigurableEnvironmentInterface $environment
     */
    public function register(ConfigurableEnvironmentInterface $environment): void
    {
        foreach ($this->blockParsers as $blockParser) {
            $environment->addBlockParser($blockParser);
        }

        foreach ($this->inlineParsers as $inlineParser) {
            $environment->addInlineParser($inlineParser);
        }

        foreach ($this->blockRenderers as $class => $blockRenderer) {
            $environment->addBlockRenderer($class, $blockRenderer);
        }

        foreach ($this->inlineRenderers as $class => $inlineRenderer) {
            $environment->addInlineRenderer($class, $inlineRenderer);
        }
    }
}

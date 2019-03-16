<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel;

use Illuminate\Container\Container;
use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use JohnnyHuy\Laravel\Block\Parser\TextAlignmentParser;
use JohnnyHuy\Laravel\Block\Renderer\TextAlignmentRenderer;
use JohnnyHuy\Laravel\Inline\Element\Codepen;
use JohnnyHuy\Laravel\Inline\Element\Gist;
use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use JohnnyHuy\Laravel\Inline\Parser\CodepenParser;
use JohnnyHuy\Laravel\Inline\Parser\GistParser;
use JohnnyHuy\Laravel\Inline\Parser\SoundCloudParser;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;
use JohnnyHuy\Laravel\Inline\Renderer\CodepenRenderer;
use JohnnyHuy\Laravel\Inline\Renderer\GistRenderer;
use JohnnyHuy\Laravel\Inline\Renderer\SoundCloudRenderer;
use JohnnyHuy\Laravel\Inline\Renderer\YouTubeRenderer;
use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\Extension\Extension;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

/**
 * This is the useful CommonMark extension class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class UsefulCommonMarkExtension extends Extension
{
    /**
     * @var array
     */
    protected $inlineParsers;

    /**
     * @var array
     */
    protected $inlineRenderers;

    /**
     * @var array
     */
    protected $blockParsers;

    /**
     * @var array
     */
    protected $blockRenderers;

    /**
     * Use an IoC container to inject dependencies.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->inlineParsers = [
            $container->make(GistParser::class),
            $container->make(CodepenParser::class),
            $container->make(YouTubeParser::class),
            $container->make(SoundCloudParser::class),
            $container->make(Inline\Parser\OpenColorParser::class),
            $container->make(Inline\Parser\CloseColorParser::class),
        ];

        $this->inlineRenderers = [
            Gist::class => $container->make(GistRenderer::class),
            Codepen::class => $container->make(CodepenRenderer::class),
            YouTube::class => $container->make(YouTubeRenderer::class),
            SoundCloud::class => $container->make(SoundCloudRenderer::class),
            Inline\Element\Color::class => $container->make(Inline\Renderer\ColorRenderer::class)
        ];

        $this->blockParsers = [
            $container->make(TextAlignmentParser::class),
            $container->make(Block\Parser\ColorParser::class),
        ];

        $this->blockRenderers = [
            TextAlignment::class => $container->make(TextAlignmentRenderer::class),
            Block\Element\Color::class => $container->make(Block\Renderer\ColorRenderer::class),
        ];
    }

    /**
     * @return array|InlineRendererInterface[]
     */
    public function getInlineRenderers()
    {
        return $this->inlineRenderers;
    }

    /**
     * @return BlockRendererInterface[]
     */
    public function getBlockRenderers()
    {
        return $this->blockRenderers;
    }

    /**
     * @return InlineParserInterface[]
     */
    public function getInlineParsers()
    {
        return $this->inlineParsers;
    }

    /**
     * @return array|BlockParserInterface[]
     */
    public function getBlockParsers()
    {
        return $this->blockParsers;
    }
}

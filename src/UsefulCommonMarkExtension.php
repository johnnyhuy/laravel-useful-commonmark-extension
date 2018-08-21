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

use Illuminate\Container\Container;
use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use JohnnyHuy\Laravel\Block\Parser\TextAlignmentParser;
use JohnnyHuy\Laravel\Block\Renderer\TextAlignmentRenderer;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use JohnnyHuy\Laravel\Inline\Parser\YouTubeParser;
use JohnnyHuy\Laravel\Inline\Renderer\YouTubeRenderer;
use League\CommonMark\Extension\Extension;

/**
 * This is the emoji extension class.
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
            $container->make(YouTubeParser::class),
        ];

        $this->inlineRenderers = [
            YouTube::class => $container->make(YouTubeRenderer::class),
        ];

        $this->blockParsers = [
            $container->make(TextAlignmentParser::class),
        ];

        $this->blockRenderers = [
            TextAlignment::class => $container->make(TextAlignmentRenderer::class),
        ];
    }

    /**
     * @return array|\League\CommonMark\Inline\Renderer\InlineRendererInterface[]
     */
    public function getInlineRenderers()
    {
        return $this->inlineRenderers;
    }

    /**
     * @return \League\CommonMark\Block\Renderer\BlockRendererInterface[]
     */
    public function getBlockRenderers()
    {
        return $this->blockRenderers;
    }

    /**
     * @return \League\CommonMark\Inline\Parser\InlineParserInterface[]
     */
    public function getInlineParsers()
    {
        return $this->inlineParsers;
    }

    /**
     * @return array|\League\CommonMark\Block\Parser\BlockParserInterface[]
     */
    public function getBlockParsers()
    {
        return $this->blockParsers;
    }
}

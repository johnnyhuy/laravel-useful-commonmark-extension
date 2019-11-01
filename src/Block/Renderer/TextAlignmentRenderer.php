<?php

namespace JohnnyHuy\Laravel\Block\Renderer;

use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;

class TextAlignmentRenderer implements BlockRendererInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractBlock $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool $inTightList
     * @return HtmlElement|string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof TextAlignment)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($block));
        }

        if ($block->data['direction'] == 'center'
            || $block->data['direction'] == 'left'
            || $block->data['direction'] == 'right') {
            /** @var AbstractBlock[] $children */
            $children = $block->children();
            $innerElements = $htmlRenderer->renderBlocks($children);
            $separator = $htmlRenderer->getOption('inner_separator', "\n");
            return new HtmlElement(
                'section',
                ['style' => "text-align: " . $block->data['direction']],
                $separator . $innerElements . $separator
            );
        }

        throw new \InvalidArgumentException('Incompatible text align type: ' . $block->data['direction']);
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}


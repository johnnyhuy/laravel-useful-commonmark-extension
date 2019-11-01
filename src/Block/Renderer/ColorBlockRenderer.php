<?php

namespace JohnnyHuy\Laravel\Block\Renderer;

use JohnnyHuy\Laravel\Block\Element\BlockColor;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;

class ColorBlockRenderer implements BlockRendererInterface
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
        if (!($block instanceof BlockColor)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($block));
        }

        $match = [];
        if (preg_match("/^\d{1,3}\,\s?\d{1,3}\,\s?\d{1,3}$/", $block->data['color'], $match)) {
            $color = "rgb($match[0])";
        } else if (preg_match("/^\d{1,3}\,\s?\d{1,3}\,\s?\d{1,3},\s?\d{1,3}$/", $block->data['color'], $match)) {
            $color = "rgba($match[0])";
        } else if (preg_match("/^\#?[A-z]+$/", $block->data['color'], $match)) {
            $color = $match[0];
        } else {
            throw new \InvalidArgumentException('Incompatible color type: ' . $block->data['color']);
        }

        /** @var AbstractBlock[] $children */
        $children = $block->children();
        $innerElements = $htmlRenderer->renderBlocks($children);
        $separator = $htmlRenderer->getOption('inner_separator', "\n");
        return new HtmlElement(
            'section',
            ['style' => "color: " . $color],
            $separator . $innerElements . $separator
        );
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}


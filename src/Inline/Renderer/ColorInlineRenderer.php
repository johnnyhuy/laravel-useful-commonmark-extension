<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use InvalidArgumentException;
use JohnnyHuy\Laravel\Inline\Element\InlineColor;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\ConfigurationInterface;

class ColorInlineRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractInline|AbstractWebResource $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement|string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof InlineColor)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        /** @var AbstractInline[] $children */
        $children = $inline->children();
        $innerElements = $htmlRenderer->renderInlines($children);

        return new HtmlElement('span', ['style' => "color: {$inline->getData('color')}"], $innerElements);
    }

    /**
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}

<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use JohnnyHuy\Laravel\Inline\Element\YouTube;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\ConfigurationInterface;

class YouTubeRenderer implements InlineRendererInterface, ConfigurationAwareInterface
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
        if (!($inline instanceof YouTube)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        // Create a new iframe with the given youtube url
        $iframe = new HtmlElement('iframe', [
            'src' => $inline->getUrl(),
            'type' => "text/html",
            'frameborder' => 0,
        ]);

        // Return the iframe with a span as wrapper element
        return new HtmlElement('span', ['class' => 'youtube-video'], $iframe);
    }

    /**
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}

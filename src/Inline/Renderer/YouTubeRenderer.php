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

class YouTubeRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractInline|AbstractWebResource $inline
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     *
     * @return \League\CommonMark\HtmlElement|string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof YouTube)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $iframe = new HtmlElement('iframe', [
            'width' => 640,
            'height' => 390,
            'src' => $inline->getUrl(),
            'type' => "text/html",
            'frameborder' => 0,
        ]);

        return new HtmlElement('span', ['class' => 'youtube-video'], $iframe);
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}

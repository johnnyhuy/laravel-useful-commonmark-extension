<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;

class SoundCloudRenderer implements InlineRendererInterface, ConfigurationAwareInterface
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
     * @throws \ErrorException
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof SoundCloud)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $url = "https://soundcloud.com/oembed?&format=json&url={$inline->getUrl()}&maxheight=166";

        // Use a oEmbed route to get SoundCloud details
        $oEmbed = file_get_contents($url);

        if (is_null($oEmbed)) {
            throw new \ErrorException('SoundCloud request returned null: ' . $url);
        }

        $oEmbed = json_decode($oEmbed);

        return $oEmbed->html;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}

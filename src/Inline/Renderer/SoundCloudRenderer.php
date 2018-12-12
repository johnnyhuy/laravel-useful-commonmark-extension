<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;
use League\CommonMark\ElementRendererInterface;
use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class SoundCloudRenderer implements InlineRendererInterface
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

        // Use a oEmbed route to get SoundCloud details
        $url = "https://soundcloud.com/oembed?&format=json&url={$inline->getUrl()}&maxheight=166";
        $soundCloud = $this->getContent($url);

        //seems that the used soundcloud url is invalid
        //or soundcloud is currently not available
        if (is_null($soundCloud)) {
            throw new \ErrorException('SoundCloud request returned null: ' . $url);
        }

        //parse the oembed response
        $soundCloud = json_decode($soundCloud);

        //use the oembed html snippet as response 
        return $soundCloud->html;
    }

    /**
     * @param string $url
     * @return string
     */
    public function getContent(string $url): string
    {
        return file_get_contents($url);
    }
}

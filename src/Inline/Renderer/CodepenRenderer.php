<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;
use JohnnyHuy\Laravel\Inline\Element\Codepen;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class CodepenRenderer implements InlineRendererInterface
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
        if (!($inline instanceof Codepen)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        // Use a oEmbed route to get codepen details
        $apiUrl = "https://codepen.io/api/oembed?url={$inline->getUrl()}&format=json";
        
        $apiResponse = $this->getContent($apiUrl);

        if (is_null($apiResponse)) {
            throw new \ErrorException('Codepen request returned null: ' . $apiUrl);
        }

        $embed = json_decode($apiResponse);

        return new HtmlElement('div', ['class' => 'codepen-container'], $embed->html);
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

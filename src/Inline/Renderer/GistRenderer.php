<?php

namespace JohnnyHuy\Laravel\Inline\Renderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\Util\Configuration;
use JohnnyHuy\Laravel\Inline\Element\Gist;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Inline\Element\AbstractWebResource;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class GistRenderer implements InlineRendererInterface
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
        if (!($inline instanceof Gist)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        //generates the same script element, which you can see
        //in the "embed gist" input field
        $script = new HtmlElement('script', [
            'src' => $inline->getUrl().'.js'
        ]);

        //add a div wrapper around the script element
        return new HtmlElement('div', ['class' => 'gist-container'], $script);
    }

    /**
     * @param string $url
     * @return string
     */
    public function getContent(string $url) : string
    {
        return file_get_contents($url);
    }
}

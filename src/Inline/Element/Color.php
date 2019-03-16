<?php

namespace JohnnyHuy\Laravel\Inline\Element;

use League\CommonMark\Inline\Element\AbstractInlineContainer;

class Color extends AbstractInlineContainer {
    protected $content;

    /**
     * @param string $contents
     * @param array  $data
     */
    public function __construct(string $contents = '', array $data = [])
    {
        $this->content = $contents;
        $this->data = $data;
    }
}

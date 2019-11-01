<?php

namespace JohnnyHuy\Laravel\Inline\Element;

use League\CommonMark\Inline\Element\AbstractStringContainer;

class InlineColor extends AbstractStringContainer
{
    protected $content;

    /**
     * @param string $contents
     * @param array  $data
     */
    public function __construct(string $contents = '', array $data = [])
    {
        parent::__construct($contents, $data);
        $this->content = $contents;
        $this->data = $data;
    }
}

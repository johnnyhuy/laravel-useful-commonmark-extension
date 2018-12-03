<?php

declare(strict_types = 1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use JohnnyHuy\Laravel\Inline\Element\Gist;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Inline\Parser\AbstractInlineParser;

class GistParser extends AbstractInlineParser
{
    /**
     * @param InlineParserContext $inlineContext
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        $savedState = $cursor->saveState();

        $cursor->advance();

        $regex = '/^(?:gist)\s(https:\/\/gist.github.com\/([^\/]+\/)?([a-zA-Z0-9]+)\/([a-zA-Z0-9]+)?)/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);

        $inlineContext->getContainer()->appendChild(new Gist($matches[1]));

        return true;
    }

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        return [':'];
    }
}

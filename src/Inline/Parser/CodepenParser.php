<?php

declare(strict_types = 1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use League\CommonMark\InlineParserContext;
use JohnnyHuy\Laravel\Inline\Element\Codepen;
use League\CommonMark\Inline\Parser\AbstractInlineParser;

class CodepenParser extends AbstractInlineParser
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

        $regex = '/^(?:codepen)\s(https:\/\/codepen\.io\/([^\/]+\/)?([a-zA-Z0-9]+)\/pen\/([a-zA-Z0-9]+)?)/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);

        $inlineContext->getContainer()->appendChild(new Codepen($matches[1]));

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

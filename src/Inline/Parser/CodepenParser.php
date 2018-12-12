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

        //check that the given user input is a valid codepen url
        //and the required `codepen:` prefix exists
        $regex = '/^(?:codepen)\s(https:\/\/codepen\.io\/([^\/]+\/)?([a-zA-Z0-9]+)\/pen\/([a-zA-Z0-9]+)?)/';
        $validate = $cursor->match($regex);

        //the computer says no
        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);
        
        //return the given codepen url to the renderer class
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

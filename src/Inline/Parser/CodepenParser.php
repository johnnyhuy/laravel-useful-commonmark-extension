<?php

declare(strict_types = 1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use JohnnyHuy\Laravel\Inline\Element\Codepen;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

class CodepenParser implements InlineParserInterface
{
    /**
     * @param InlineParserContext $inlineContext
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $savedState = $cursor->saveState();

        $cursor->advance();

        // Check that the given user input is a valid Codepen url
        // and the required `codepen:` prefix exists
        $regex = '/^(?:codepen)\s(https:\/\/codepen\.io\/([^\/]+\/)?([a-zA-Z0-9]+)\/pen\/([a-zA-Z0-9]+)?)/';
        $validate = $cursor->match($regex);

        // The computer says no
        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);

        // Return the given codepen url to the renderer class
        $inlineContext->getContainer()->appendChild(new Codepen($matches[1]));

        return true;
    }

    /**
     * @return string[]
     */
    public function getCharacters(): array
    {
        return [':'];
    }
}

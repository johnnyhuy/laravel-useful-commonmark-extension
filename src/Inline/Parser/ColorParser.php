<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use JohnnyHuy\Laravel\Inline\Element\Color;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

class ColorParser extends AbstractInlineParser
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

        $regex = '/(?:color|colour)(?:\s(?:(\#?[A-z0-9]+|\d{1,3}\,\s?\d{1,3}\,\s?\d{1,3}(\,\s?\d{1,3})?)))\s(.*(?!:color))\s(?:\:color)/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);
            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);
        [, $color, $alpha, $content] = $matches;

        if (preg_match('/[\,]+/', $color, $_)) {
            if (empty($alpha)) {
                $color = "rgb({$color})";
            } else {
                $color = "rgba({$color})";
            }
        }

        $data['color'] = $color;

        $inlineContext->getContainer()->appendChild(new Color($content, $data));

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

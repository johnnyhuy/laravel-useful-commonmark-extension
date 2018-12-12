<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use League\CommonMark\InlineParserContext;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use League\CommonMark\Inline\Parser\AbstractInlineParser;

class YouTubeParser extends AbstractInlineParser
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

        //regex to ensure that we got a valid youtube url
        //and the required `youtube:` prefix exists
        $regex = '/^(?:youtube)\s(?:https?\:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&#\s\?]+)(?:\?.[^\s]+)?/';
        $validate = $cursor->match($regex);

        //the computer says no
        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);
        $videoId = $matches[1];

        //generates a valid youtube embed url with the parsed video id from the given url
        $inlineContext->getContainer()->appendChild(new YouTube("https://www.youtube.com/embed/$videoId"));

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

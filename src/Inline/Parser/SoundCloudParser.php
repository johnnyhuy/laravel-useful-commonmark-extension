<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use JohnnyHuy\Laravel\Inline\Element\YouTube;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

class SoundCloudParser extends AbstractInlineParser
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

        $regex = '/^(?:soundcloud|sc)\s((?:https?\:\/\/)?(?:www\.)?(?:soundcloud\.com\/)([^&#\s\?]+\/[^&#\s\?]+))/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $inlineContext->getContainer()->appendChild(new SoundCloud(ltrim($validate, 'soundcloud ')));

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

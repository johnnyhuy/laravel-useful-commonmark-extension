<?php

declare(strict_types=1);

/*
 * This file is part of Alt Three Emoji.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JohnnyHuy\Laravel\Inline\Parser;

use JohnnyHuy\Laravel\Inline\Element\YouTube;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

/**
 * This is the emoji parser class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class YouTubeParser extends AbstractInlineParser
{
    /**
     * Parse a line and determine if it contains an emoji.
     *
     * If it does, then we do the necessary.
     *
     * @param InlineParserContext $inlineContext
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        $savedState = $cursor->saveState();

        $cursor->advance();

        $regex = '/^youtube\s(?:https?\:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&#\s\?]+)(?:\?.[^\s]+)?/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);

            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);
        $videoId = $matches[1];

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

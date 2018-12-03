<?php

namespace JohnnyHuy\Laravel\Block\Element;

use League\CommonMark\Cursor;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\ContextInterface;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\InlineContainerInterface;

class TextAlignment extends AbstractBlock implements InlineContainerInterface {
    /**
     * Returns true if this block can contain the given block as a child node
     *
     * @param AbstractBlock $block
     *
     * @return bool
     */
    public function canContain(AbstractBlock $block)
    {
        return true;
    }

    /**
     * Returns true if block type can accept lines of text
     *
     * @return bool
     */
    public function acceptsLines()
    {
        return false;
    }

    /**
     * Whether this is a code block
     *
     * @return bool
     */
    public function isCode()
    {
        return false;
    }

    /**
     * Checks the next line, if true then continue.
     *
     * @param Cursor $cursor
     * @return bool
     */
    public function matchesNextLine(Cursor $cursor)
    {
        return true;
    }

    /**
     * @param ContextInterface $context
     * @param Cursor           $cursor
     */
    public function handleRemainingContents(ContextInterface $context, Cursor $cursor)
    {
        $context->getTip()->addLine($cursor->getRemainder());
    }

    /**
     * @param Cursor $cursor
     * @param int    $currentLineNumber
     *
     * @return bool
     */
    public function shouldLastLineBeBlank(Cursor $cursor, $currentLineNumber)
    {
        return true;
    }
}

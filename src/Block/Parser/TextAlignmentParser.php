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

namespace JohnnyHuy\Laravel\Block\Parser;

use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use League\CommonMark\Block\Parser\AbstractBlockParser;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

/**
 * Text alignment parser class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class TextAlignmentParser extends AbstractBlockParser
{
    /**
     * Parse a line and determine if it contains an emoji.
     *
     * If it does, then we do the necessary.
     *
     * @param ContextInterface $context
     * @param Cursor $cursor
     * @return bool
     */
    public function parse(ContextInterface $context, Cursor $cursor)
    {
        if ($cursor->isIndented()) {
            return false;
        }

        $savedState = $cursor->saveState();
        $match = $cursor->match('/^\:text\-(right|left|center)$/');
        $container = $context->getContainer();

        if (is_null($match)) {
            $cursor->restoreState($savedState);
            return false;
        }


        // Find the next TextAlignment container as we go up in parent nodes
        do {
            if ($container instanceof TextAlignment) {
                $context->setContainer($container);
                $container->finalize($context, $context->getLineNumber());
                $context->getBlockCloser()->setLastMatchedContainer($container);

                return true;
            }
        } while ($container = $container->parent());

        $block = new TextAlignment();
        $block->data['direction'] = ltrim($match, ':text-');
        $context->addBlock($block);

        return true;
    }
}

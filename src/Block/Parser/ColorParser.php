<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Block\Parser;

use League\CommonMark\Cursor;
use League\CommonMark\ContextInterface;
use JohnnyHuy\Laravel\Block\Element\Color;
use League\CommonMark\Block\Parser\AbstractBlockParser;

/**
 * Text alignment parser class.
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class ColorParser extends AbstractBlockParser
{
    /**
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
        $match = $cursor->match('/^\:(?:color|colour)(\s(?:(\#?[A-z]+|\d{1,3}\,\s?\d{1,3}\,\s?\d{1,3}(\,\s?\d{1,3})?)))?$/');
        $container = $context->getContainer();

        if (is_null($match)) {
            $cursor->restoreState($savedState);
            return false;
        }

        do {
            if ($container instanceof Color) {
                $context->setContainer($container);
                $container->finalize($context, $context->getLineNumber());
                $context->getBlockCloser()->setLastMatchedContainer($container);

                return true;
            }
        } while ($container = $container->parent());


        // Trim off the :color segment
        $color = preg_split("/^\:(?:color|colour)\s/", $match);

        if (!array_key_exists(1, $color)) {
            return false;
        }

        $block = new Color();
        $block->data['color'] = $color[1];
        $context->addBlock($block);

        return true;
    }
}

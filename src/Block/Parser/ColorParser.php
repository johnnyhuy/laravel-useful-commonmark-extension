<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Block\Parser;

use JohnnyHuy\Laravel\Block\Element\Color;
use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use League\CommonMark\Block\Parser\AbstractBlockParser;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

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
        $match = $cursor->match('/^\:(?:color|colour)(\s(?:(\#?([A-z0-9]{6})|\d{3}\,\s?\d{3}\,\s?\d{3}(\,\s?\d{3})?)|[A-z]+))?$/');
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

        $block = new Color();

        // Trim off the :color segment
        $block->data['color'] = preg_split("/^\:(?:color|colour)\s/", $match)[1];

        $context->addBlock($block);

        return true;
    }
}

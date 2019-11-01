<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use League\CommonMark\Delimiter\DelimiterStack;
use League\CommonMark\Environment;
use League\CommonMark\EnvironmentAwareInterface;
use League\CommonMark\EnvironmentInterface;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

class CloseColorParser implements InlineParserInterface, EnvironmentAwareInterface
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @param InlineParserContext $inlineContext
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext): bool
    {
        $opener = $inlineContext->getDelimiterStack()->searchByCharacter([':']);
        if ($opener === null) {
            return false;
        }

        if (!$opener->isActive()) {
            $inlineContext->getDelimiterStack()->removeDelimiter($opener);
            return false;
        }

        $cursor = $inlineContext->getCursor();
        $savedState = $cursor->saveState();

        $regex = '/(?:color|colour)/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);
            return false;
        }

        $inline = $opener->getInlineNode();
        while (($label = $inline->next()) !== null) {
            $inline->appendChild($label);
        }

        $delimiterStack = $inlineContext->getDelimiterStack();
        $stackBottom = $opener->getPrevious();

        // Do the delimiter processor magic here!
        $delimiterStack->processDelimiters($stackBottom, $this->environment->getDelimiterProcessors());

        if ($delimiterStack instanceof DelimiterStack) {
            $delimiterStack->removeAll($stackBottom);
        }

        return true;
    }

    /**
     * @return string[]
     */
    public function getCharacters(): array
    {
        return [':'];
    }

    /**
     * @param EnvironmentInterface $environment
     *
     * @return void
     */
    public function setEnvironment(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }
}

<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use League\CommonMark\Delimiter\DelimiterStack;
use League\CommonMark\Environment;
use League\CommonMark\EnvironmentAwareInterface;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

class CloseColorParser extends AbstractInlineParser implements EnvironmentAwareInterface
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @param InlineParserContext $inlineContext
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
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
        foreach ($this->environment->getInlineProcessors() as $inlineProcessor) {
            $inlineProcessor->processInlines($delimiterStack, $stackBottom);
        }

        if ($delimiterStack instanceof DelimiterStack) {
            $delimiterStack->removeAll($stackBottom);
        }

        return true;
    }

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        return [':'];
    }

    /**
     * @param Environment $environment
     *
     * @return void
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
    }
}

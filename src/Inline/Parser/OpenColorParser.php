<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Inline\Parser;

use JohnnyHuy\Laravel\Inline\Element\InlineColor;
use League\CommonMark\Delimiter\Delimiter;
use League\CommonMark\Environment;
use League\CommonMark\EnvironmentAwareInterface;
use League\CommonMark\EnvironmentInterface;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

class OpenColorParser implements InlineParserInterface, EnvironmentAwareInterface
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
        $character = $inlineContext->getCursor()->getCharacter();
        if ($character !== ':') {
            return false;
        }

        $cursor = $inlineContext->getCursor();
        $savedState = $cursor->saveState();

        $regex = '/(?:color|colour)\-(\#[A-z0-9]{3,6}|[A-z]+|\d{1,3}\,\d{1,3}\,\d{1,3}(?:\,\d{1,3})?)/';
        $validate = $cursor->match($regex);

        if (!$validate) {
            $cursor->restoreState($savedState);
            return false;
        }

        $matches = [];
        preg_match($regex, $validate, $matches);
        [,$color] = $matches;

        if (preg_match('/(.*?[\,].*?){3}/', $color, $_)) {
            $color = "rgba({$color})";
        } else if (preg_match('/(.*?[\,].*?){2}/', $color, $_)) {
            $color = "rgb({$color})";
        }

        $inline = new InlineColor($cursor->getPreviousText(), [
            'delim' => true,
            'color' => $color,
        ]);
        $inlineContext->getContainer()->appendChild($inline);

        $delimiter = new Delimiter($character, 1, $inline, true, false, $inlineContext->getCursor()->getPosition());
        $inlineContext->getDelimiterStack()->push($delimiter);

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

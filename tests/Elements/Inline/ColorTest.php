<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements\Inline;

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use JohnnyHuy\Laravel\Block\Parser\ColorParser;
use JohnnyHuy\Laravel\Inline\Element\InlineColor;
use JohnnyHuy\Laravel\Inline\Parser\CloseColorParser;
use JohnnyHuy\Laravel\Inline\Parser\OpenColorParser;
use JohnnyHuy\Laravel\Inline\Renderer\ColorInlineRenderer;
use PHPUnit\Framework\ExpectationFailedException;
use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * CommonMak markdown extension test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class ColorTest extends BaseTestCase
{
    public static function successfulStrings(): array
    {
        return [
            [":color-red *[Link](http://example.com)* Heading :color test\ntest", "<p><span style=\"color: red\"> <em><a href=\"http://example.com\">Link</a></em> Heading </span> test\ntest</p>"],
            [":color-155,123,422 red **Heading** :color\ntest", "<p><span style=\"color: rgb(155,123,422)\"> red <strong>Heading</strong> </span>\ntest</p>"],
            [':color-155,123,422,50 red **Heading** :color', '<p><span style="color: rgba(155,123,422,50)"> red <strong>Heading</strong> </span></p>'],
            ['testing :color-155,123,422,50 red **Heading** :color testing', '<p>testing <span style="color: rgba(155,123,422,50)"> red <strong>Heading</strong> </span> testing</p>'],
            ['testing :color-#333 red **Heading** :color testing', '<p>testing <span style="color: #333"> red <strong>Heading</strong> </span> testing</p>'],
            ['testing :color-#aaaaaa red **Heading** :color testing', '<p>testing <span style="color: #aaaaaa"> red <strong>Heading</strong> </span> testing</p>'],
        ];
    }

    public static function failedStrings(): array
    {
        return [
            [':color @Heading **bold text** test :color test', '<p>:color @Heading <strong>bold text</strong> test :color test</p>'],
            [':coloor red Heading **bold text** test :color test', '<p>:coloor red Heading <strong>bold text</strong> test :color test</p>'],
            ['color red Heading **bold text** test :color test', '<p>color red Heading <strong>bold text</strong> test :color test</p>'],
            ['color red Heading **bold text** test color pink test', '<p>color red Heading <strong>bold text</strong> test color pink test</p>'],
        ];
    }

    /**
     * @dataProvider successfulStrings
     * @param $input
     * @param $output
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testShouldRender($input, $output)
    {
        // Arrange
        $environment = Environment::createCommonMarkEnvironment();
        $parser = new DocParser($environment);
        $htmlRenderer = new HtmlRenderer($environment);
        $environment->addInlineParser(new CloseColorParser());
        $environment->addInlineParser(new OpenColorParser());
        $environment->addInlineRenderer(InlineColor::class, new ColorInlineRenderer());

        // Act
        $html = $htmlRenderer->renderBlock($parser->parse($input));

        // Arrange
        $this->assertSame("$output\n", $html);
    }

    /**
     * @dataProvider failedStrings
     * @param $input
     * @param $output
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testShouldNotRender($input, $output)
    {
        // Arrange
        $environment = Environment::createCommonMarkEnvironment();
        $parser = new DocParser($environment);
        $htmlRenderer = new HtmlRenderer($environment);
        $environment->addInlineParser(new CloseColorParser());
        $environment->addInlineParser(new OpenColorParser());
        $environment->addInlineRenderer(InlineColor::class, new ColorInlineRenderer());

        // Act
        $html = $htmlRenderer->renderBlock($parser->parse($input));

        // Arrange
        $this->assertSame("$output\n", $html);
    }
}
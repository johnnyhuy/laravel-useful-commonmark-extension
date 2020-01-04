<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements\Block;

use JohnnyHuy\Laravel\Block\Element\TextAlignment;
use JohnnyHuy\Laravel\Block\Parser\TextAlignmentParser;
use JohnnyHuy\Laravel\Block\Renderer\TextAlignmentRenderer;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use PHPUnit\Framework\ExpectationFailedException;
use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * CommonMak markdown extension test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class TextAlignmentTest extends BaseTestCase
{
    public function successfulStrings()
    {
        return [
            [":text-right\n# Heading\n\n**bold text**\ntest\n:text-right\ntest", "<section style=\"text-align: right\">\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n</section>\n<p>test</p>"]
        ];
    }

    public function failedStrings()
    {
        return [
            // Incorrect symbols
            [":text->\n# Heading\n\n**bold text**\ntest\n:text-->\ntest", "<p>:text-&gt;</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\n:text--&gt;\ntest</p>"],

            // Typo
            [":text-righttt\n# Heading\n\n**bold text**\ntest\n:text-righttt\ntest", "<p>:text-righttt</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\n:text-righttt\ntest</p>"],

            // Starting text center without ':' will cause text right to start
            ["text-center\n# Heading\n\n**bold text**\ntest\n:text-right\ntest", "<p>text-center</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n<section style=\"text-align: right\">\n<p>test</p>\n</section>"],

            // No ':' symbol will not render an alignment block
            ["text-center\n# Heading\n\n**bold text**\ntest\ntext-right\ntest", "<p>text-center</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\ntext-right\ntest</p>"],
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
        $environment->addBlockParser(new TextAlignmentParser());
        $environment->addBlockRenderer(TextAlignment::class, new TextAlignmentRenderer());

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
        $environment->addBlockParser(new TextAlignmentParser());
        $environment->addBlockRenderer(TextAlignment::class, new TextAlignmentRenderer());

        // Act
        $html = $htmlRenderer->renderBlock($parser->parse($input));

        // Arrange
        $this->assertSame("$output\n", $html);
    }
}
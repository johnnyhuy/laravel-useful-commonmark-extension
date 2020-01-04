<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements\Block;

use JohnnyHuy\Laravel\Block\Element\BlockColor;
use JohnnyHuy\Laravel\Block\Parser\ColorParser;
use JohnnyHuy\Laravel\Block\Renderer\ColorBlockRenderer;
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
class ColorTest extends BaseTestCase
{
    public function successfulStrings()
    {
        return [
            [":color red\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<section style=\"color: red\">\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n</section>\n<p>test</p>"],
            [":color 155,123,422\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<section style=\"color: rgb(155,123,422)\">\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n</section>\n<p>test</p>"],
            [":color 155,123,422\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<section style=\"color: rgb(155,123,422)\">\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n</section>\n<p>test</p>"],
            [":color 155,123,422,50\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<section style=\"color: rgba(155,123,422,50)\">\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n</section>\n<p>test</p>"],
        ];
    }

    public function failedStrings()
    {
        return [
            // No color selected
            [":color\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\n\ntest</p>"],

            // Typo
            [":coloor red\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<p>:coloor red</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\n\ntest</p>"],

            // Starting text center without ':' will cause text right to start
            ["color red\n# Heading\n\n**bold text**\ntest\n:color\ntest", "<p>color red</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\n\ntest</p>"],

            // No ':' symbol will not render an alignment block
            ["color red\n# Heading\n\n**bold text**\ntest\ncolor pink\ntest", "<p>color red</p>\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest\ncolor pink\ntest</p>"],
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
        $environment->addBlockParser(new ColorParser());
        $environment->addBlockRenderer(BlockColor::class, new ColorBlockRenderer());

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
        $environment->addBlockParser(new ColorParser());
        $environment->addBlockRenderer(BlockColor::class, new ColorBlockRenderer());

        // Act
        $html = $htmlRenderer->renderBlock($parser->parse($input));

        // Arrange
        $this->assertSame("$output\n", $html);
    }
}
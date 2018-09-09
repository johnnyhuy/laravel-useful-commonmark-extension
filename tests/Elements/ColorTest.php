<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements;

use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;

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
     */
    public function testShouldRender($input, $output)
    {
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }

    /**
     * @dataProvider failedStrings
     * @param $input
     * @param $output
     */
    public function testShouldNotRender($input, $output)
    {
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }
}
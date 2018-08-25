<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements;

use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;

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
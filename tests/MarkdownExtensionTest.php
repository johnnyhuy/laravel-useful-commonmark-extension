<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests;

use League\CommonMark\DocParser;
use PhpParser\Comment\Doc;

/**
 * Markdown Extensions test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class MarkdownExtensionTest extends BaseTestCase
{
    public function successfulYouTubeStrings()
    {
        $expected = '<p><span class="youtube-video"><iframe width="640" height="390" src="https://www.youtube.com/embed/52c_QSg64fs" type="text/html" frameborder="0"></iframe></span></p>';

        return [
            [':youtube http://www.youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube https://www.youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube http://youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube http://www.youtube.com/watch?v=52c_QSg64fs?t=10s', $expected],
            [':youtube http://www.youtube.com/watch?v=52c_QSg64fs?t=10s&something=123123123SDqweas', $expected],
        ];
    }

    public function failedYouTubeStrings()
    {
        return [
            [':youtubehttps://www.youtube.com/watch?v=USL6P8haroY', '<p>:youtubehttps://www.youtube.com/watch?v=USL6P8haroY</p>'],
            ['https://www.youtube.com/watch?v=USL6P8haroY', '<p>https://www.youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube https//www.youtube.com/watch?v=USL6P8haroY', '<p>:youtube https//www.youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube httpswww.youtube.com/watch?v=USL6P8haroY', '<p>:youtube httpswww.youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube .youtube.com/watch?v=USL6P8haroY', '<p>:youtube .youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube .com/watch?v=USL6P8haroY', '<p>:youtube .com/watch?v=USL6P8haroY</p>'],
            [':youtube poop.com/watch?v=USL6P8haroY', '<p>:youtube poop.com/watch?v=USL6P8haroY</p>'],
        ];
    }

    public function successfulTextAlignmentStrings()
    {
        return [
            [":text-right\n# Heading\n\n**bold text**\ntest\n:text-right\ntest", "<section style=\"text-align: right\">\n<h1>Heading</h1>\n<p><strong>bold text</strong>\ntest</p>\n</section>\n<p>test</p>"]
        ];
    }

    /**
     * @dataProvider successfulYouTubeStrings
     * @param $input
     * @param $output
     */
    public function testShouldRenderYouTube($input, $output)
    {
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }

    /**
     * @dataProvider failedYouTubeStrings
     * @param $input
     * @param $output
     */
    public function testShouldNotRenderYouTube($input, $output)
    {
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }

    /**
     * @dataProvider successfulTextAlignmentStrings
     * @param $input
     * @param $output
     */
    public function testShouldRenderTextAlignment($input, $output)
    {
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }
}
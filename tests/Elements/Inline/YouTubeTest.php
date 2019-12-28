<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements\Inline;

use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use PHPUnit\Framework\ExpectationFailedException;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * CommonMak markdown extension test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class YouTubeTest extends BaseTestCase
{
    public function successfulStrings()
    {
        $expected = '<p><span class="youtube-video"><iframe width="640" height="390" src="https://www.youtube.com/embed/52c_QSg64fs" type="text/html" frameborder="0"></iframe></span></p>';

        return [
            [':youtube http://www.youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube https://www.youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube http://youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube youtube.com/watch?v=52c_QSg64fs', $expected],
            [':youtube http://www.youtube.com/watch?time_continue=10&v=52c_QSg64fs', '<p><span class="youtube-video"><iframe width="640" height="390" src="https://www.youtube.com/embed/52c_QSg64fs?start=10" type="text/html" frameborder="0"></iframe></span></p>'],
            [':youtube http://www.youtube.com/watch?t=10s&v=52c_QSg64fs', '<p><span class="youtube-video"><iframe width="640" height="390" src="https://www.youtube.com/embed/52c_QSg64fs?start=10" type="text/html" frameborder="0"></iframe></span></p>'],
            [':youtube http://www.youtube.com/watch?v=52c_QSg64fs&t=10s', '<p><span class="youtube-video"><iframe width="640" height="390" src="https://www.youtube.com/embed/52c_QSg64fs?start=10" type="text/html" frameborder="0"></iframe></span></p>'],
            [':youtube http://www.youtube.com/watch?v=52c_QSg64fs&t=10s&something=123123123SDqweas', '<p><span class="youtube-video"><iframe width="640" height="390" src="https://www.youtube.com/embed/52c_QSg64fs?start=10" type="text/html" frameborder="0"></iframe></span></p>'],
        ];
    }

    public function failedStrings()
    {
        return [
            // YouTube keyword is not separated with a space
            [':youtubehttps://www.youtube.com/watch?v=USL6P8haroY', '<p>:youtubehttps://www.youtube.com/watch?v=USL6P8haroY</p>'],

            // Didn't include the ':youtube' keyword
            ['https://www.youtube.com/watch?v=USL6P8haroY', '<p>https://www.youtube.com/watch?v=USL6P8haroY</p>'],

            // Invalid YouTube URLs
            [':youtube https//www.youtube.com/watch?v=USL6P8haroY', '<p>:youtube https//www.youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube httpswww.youtube.com/watch?v=USL6P8haroY', '<p>:youtube httpswww.youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube .youtube.com/watch?v=USL6P8haroY', '<p>:youtube .youtube.com/watch?v=USL6P8haroY</p>'],
            [':youtube .com/watch?v=USL6P8haroY', '<p>:youtube .com/watch?v=USL6P8haroY</p>'],
            [':youtube poop.com/watch?v=USL6P8haroY', '<p>:youtube poop.com/watch?v=USL6P8haroY</p>'],
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
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
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
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }
}
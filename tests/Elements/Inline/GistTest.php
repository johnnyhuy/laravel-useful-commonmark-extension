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
class GistTest extends BaseTestCase
{
    public function successfulStrings()
    {
        $expected = '<p><div class="gist-container"><script src="https://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e.js"></script></div></p>';

        return [
            [':gist https://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e', $expected]
        ];
    }

    public function failedStrings()
    {
        return [
            // gist keyword is not separated with a space
            [':gisthttps://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e', '<p>:gisthttps://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e</p>'],

            // Didn't include the ':gist' keyword
            ['https://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e', '<p>https://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e</p>'],

            // Invalid gist URLs
            [':gist https//gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e', '<p>:gist https//gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e</p>'],
            [':gist http://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e', '<p>:gist http://gist.github.com/noxify/2b02fd0fb0ea18a4d9d764e31fe9af8e</p>'],
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
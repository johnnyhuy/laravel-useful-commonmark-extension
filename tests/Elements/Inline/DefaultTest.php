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
class DefaultTest extends BaseTestCase
{
    public static function strings(): array
    {
        return [
            ["**this is meant to be bold**", "<p><strong>this is meant to be bold</strong></p>"],
            ["*this is meant to be bold*", "<p><em>this is meant to be bold</em></p>"],
        ];
    }

    /**
     * @dataProvider strings
     * @param $input
     * @param $output
     * @throws ExpectationFailedException
     * @throws InvalidArgumentException
     */
    public function testShouldRender($input, $output)
    {
        $this->assertSame("$output\n", $this->app->markdown->convertToHtml($input));
    }
}
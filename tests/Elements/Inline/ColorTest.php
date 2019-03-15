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
class ColorTest extends BaseTestCase
{
    public static function successfulStrings(): array
    {
        return [
            [":color red Heading :color test\ntest", "<p><span style=\"color: red\">Heading</span> test\ntest</p>"],
            [":color 155,123,422 red **Heading** :color\ntest", "<p><span style=\"color: rgb(155,123,422)\">red **Heading**</span>\ntest</p>"],
            [':color 155,123,422,50 red **Heading** :color', '<p><span style="color: rgba(155,123,422,50)">red **Heading**</span></p>'],
            ['testing :color 155,123,422,50 red **Heading** :color testing', '<p>testing <span style="color: rgba(155,123,422,50)">red **Heading**</span> testing</p>'],
            ['testing :color #333 red **Heading** :color testing', '<p>testing <span style="color: #333">red <strong>Heading</strong></span> testing</p>'],
            ['testing :color #aaaaaa red **Heading** :color testing', '<p>testing <span style="color: #aaaaaa">red <strong>Heading</strong></span> testing</p>'],
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
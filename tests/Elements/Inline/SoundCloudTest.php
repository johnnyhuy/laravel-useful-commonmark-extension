<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements;

use Mockery;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use JohnnyHuy\Laravel\Inline\Element\SoundCloud;
use PHPUnit\Framework\ExpectationFailedException;
use JohnnyHuy\Laravel\Inline\Parser\SoundCloudParser;
use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use JohnnyHuy\Laravel\Inline\Renderer\SoundCloudRenderer;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

/**
 * CommonMak markdown extension test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class SoundCloudTest extends BaseTestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function successfulStrings()
    {
        $expected = '<p><iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?visual=true&url=https%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F489177243&show_artwork=true&maxheight=166"></iframe></p>';

        return [
            [':soundcloud http://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud https://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud http://soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
        ];
    }

    public function failedStrings()
    {
        return [
            // SoundCloud keyword is not separated with a space
            [':soundcloudhttps://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloudhttps://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],

            // Didn't include the ':soundcloud' keyword
            ['https://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>https://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],

            // Invalid SoundCloud URLs
            [':soundcloud https//www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloud https//www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],
            [':soundcloud httpswww.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloud httpswww.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],
            [':soundcloud .soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloud .soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],
            [':soundcloud .com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloud .com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],
            [':soundcloud poop.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloud poop.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],
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
        $rendererMock = Mockery::mock(SoundCloudRenderer::class)
            ->makePartial()
            ->shouldReceive('getContent')
            ->withAnyArgs()
            ->once()
            ->andReturn(file_get_contents(__DIR__ . '/../../Fakes/SoundCloudTrack.json'));
        $environment = Environment::createCommonMarkEnvironment();
        $parser = new DocParser($environment);
        $htmlRenderer = new HtmlRenderer($environment);
        $environment->addInlineParser(new SoundCloudParser());
        $environment->addInlineRenderer(SoundCloud::class, $rendererMock->getMock());

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
        $environment->addInlineParser(new SoundCloudParser());
        $environment->addInlineRenderer(SoundCloud::class, new SoundCloudRenderer() );

        // Act
        $html = $htmlRenderer->renderBlock($parser->parse($input));

        // Arrange
        $this->assertSame("$output\n", $html);
    }
}
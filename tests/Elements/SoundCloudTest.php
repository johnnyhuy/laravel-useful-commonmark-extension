<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements;

use JohnnyHuy\Laravel\Inline\Renderer\SoundCloudRenderer;
use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;
use Mockery;

/**
 * CommonMak markdown extension test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class SoundCloudTest extends BaseTestCase
{
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
     */
    public function testShouldRender($input, $output)
    {
        // Mock the SoundCloud renderer so we don't have to do HTTP calls
        $mock = Mockery::mock(SoundCloudRenderer::class)
            ->makePartial()
            ->shouldReceive( 'getContent' )
            ->once()
            ->andReturn('{"version":1.0,"type":"rich","provider_name":"SoundCloud","provider_url":"http://soundcloud.com","height":166,"width":"100%","title":"Marshmello x Bastille - Happier (Koni Remix)(Andrea Hamilton Cover) by Koni","description":"A Remix I put together from Andrea Hamilton\'s Happier Cover. Hope you like it!\nFree Download:\nhttps://Koni.lnk.to/Happier_Download\n\nCheck Out My Instagram: https://Koni.lnk.to/instagram\nMy Playlist for Other Great Tunes: https://Koni.lnk.to/Hang_Out\n\nCheck Out The Singer Andrea Hamilton:\nhttps://soundcloud.com/andreahamilton\nhttps://www.youtube.com/user/andreahamilton\nhttps://www.facebook.com/HopefulAndrea\nhttps://twitter.com/HopefulAndrea","thumbnail_url":"http://i1.sndcdn.com/artworks-000393029532-27skb8-t500x500.jpg","html":"\u003Ciframe width=\"100%\" height=\"166\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?visual=true\u0026url=https%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F489177243\u0026show_artwork=true\u0026maxheight=166\"\u003E\u003C/iframe\u003E","author_name":"Koni","author_url":"https://soundcloud.com/koni_music"}');
        $this->app->instance(SoundCloudRenderer::class, $mock->getMock());

        $html = $this->app->markdown->convertToHtml($input);
        $this->assertSame("$output\n", $html);
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
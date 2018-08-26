<?php

declare(strict_types=1);

namespace JohnnyHuy\Laravel\Markdown\Tests\Elements;

use JohnnyHuy\Laravel\Markdown\Tests\BaseTestCase;

/**
 * CommonMak markdown extension test
 *
 * @author Johnny Huynh <info@johnnyhuy.com>
 */
class SoundCloudTest extends BaseTestCase
{
    public function successfulStrings()
    {
        $expected = '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/489177243&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';

        return [
            [':soundcloud http://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud https://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud http://soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', $expected],
            [':soundcloud http://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix?t=10s', $expected],
            [':soundcloud http://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix?t=10s&something=123123123SDqweas', $expected],
        ];
    }

    public function failedStrings()
    {
        return [
            // Soundcloud keyword is not separated with a space
            [':soundcloudhttps://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>:soundcloudhttps://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],

            // Didn't include the ':soundcloud' keyword
            ['https://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix', '<p>https://www.soundcloud.com/koni_music/marshmello-x-bastille-happier-koni-feat-andrea-hamilton-cover-remix</p>'],

            // Invalid Soundcloud URLs
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
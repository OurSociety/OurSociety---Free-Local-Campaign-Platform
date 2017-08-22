<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * VideoListPage.
 */
class VideoList extends Page
{
    protected $path = '/politician/profile/videos';

    public function iEditThatVideo()
    {
    }
}

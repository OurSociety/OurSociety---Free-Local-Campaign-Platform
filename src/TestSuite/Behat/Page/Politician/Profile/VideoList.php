<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Politician\Profile;

use OurSociety\TestSuite\Behat\Page\Page;

/**
 * VideoListPage.
 */
class VideoList extends Page
{
    protected $path = '/politician/profile/videos';

    public function clickToEditVideo(string $videoId): EditVideo
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getPage(EditVideo::class)->open(['videoId' => $videoId]);
    }
}

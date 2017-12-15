<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Politician\Profile;

use OurSociety\TestSuite\Behat\Page\Component\Listing;

/**
 * Representative profile award list page
 */
class AwardList extends Listing
{
    public function clickToEditVideo(string $videoId): EditVideo
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getPage(EditVideo::class)->open(['videoId' => $videoId]);
    }

    protected function getPath(): string
    {
        return '/representative/profile/awards';
    }
}

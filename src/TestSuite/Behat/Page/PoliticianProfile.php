<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

/**
 * PoliticianProfilePage.
 */
class PoliticianProfile extends Page
{
    protected $path = '/politician/profile';

    public function hasFeaturedVideo(): bool
    {
        return $this->find('css', '.politician-video-featured iframe') !== null;
    }

    public function clickToEditVideos(): VideoList
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getPage(VideoList::class)->open();
    }
}

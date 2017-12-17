<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Common;

use Behat\Mink\Element\NodeElement;
use OurSociety\TestSuite\Behat\Page\Page;
use OurSociety\TestSuite\Behat\Page\Politician\Profile\VideoList;

/**
 * Profile.
 */
abstract class Profile extends Page
{
    public function hasFeaturedVideo(): bool
    {
        return $this->find('css', '.politician-video-featured iframe') !== null;
    }

    public function clickToEditVideos(): VideoList
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getPage(VideoList::class)->open();
    }

    public function hasAwardNamed($name): bool
    {
        return in_array($name, $this->getAwardNames(), true);
    }

    public function getRepresentativeName(): string
    {
        return $this->findByCss('#page-title')->getText();
    }

    public function verifyPage()
    {
        $this->assertHeadingsExist([
            $this->getRepresentativeName(),
            'My platform',
            'My platform',
            'About me',
            'Positions',
            'Education',
            'Awards',
            'Born',
        ]);
    }

    private function getAwardNames(): array
    {
        /** @var NodeElement[] $nodeElements */
        $nodeElements = $this->findAll('css', '.award-name');
        $awardNames = [];

        foreach ($nodeElements as $nodeElement) {
            $awardNames[] = $nodeElement->getText();
        }

        return $awardNames;
    }
}

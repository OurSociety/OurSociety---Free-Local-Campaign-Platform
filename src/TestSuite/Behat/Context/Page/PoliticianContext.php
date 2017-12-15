<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class PoliticianContext extends PageObjectContext
{
    private const VIDEO_ID_EDIT = '213e2c94-6f7c-3d58-9f2e-134b9ee3dddd';

    private $awardList;

    private $myProfile;

    public function __construct(
        Page\Politician\MyProfile $myProfile
    ) {
        $this->myProfile = $myProfile;
    }

    /**
     * @Given I am on my profile
     */
    public function iAmOnMyProfile()
    {
        $this->myProfile->open();
    }

    /**
     * @Given there is a video
     */
    public function thereIsAVideo()
    {
        if ($this->myProfile->hasFeaturedVideo() === false) {
            $message = sprintf('Expected to find a featured video.');

            throw new \LogicException($message);
        }
    }

    /**
     * @When I edit that video
     */
    public function iEditThatVideo()
    {
        $videoList = $this->myProfile->clickToEditVideos();
        $videoEditPage = $videoList->clickToEditVideo(self::VIDEO_ID_EDIT);
        $videoEditPage->setYoutubeVideoId('test');
        $videoEditPage->setAsFeatured(false);
        $videoEditPage->save();
    }

    /**
     * @Then the video is updated
     */
    public function theVideoIsUpdated()
    {
        $videoList = $this->myProfile->clickToEditVideos();
        $videoEditPage = $videoList->clickToEditVideo(self::VIDEO_ID_EDIT);
        $videoEditPage->assertYoutubeVideoId('test');
        $videoEditPage->assertFeatured(false);
    }

    /**
     * @Then I should see the award :name
     */
    public function iShouldSeeTheAward(string $name)
    {
        if ($this->myProfile->hasAwardNamed($name) === false) {
            $message = sprintf('Expected to find a award with name "%s".', $name);

            throw new \LogicException($message);
        }
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use OurSociety\TestSuite\Behat\Page\Login;
use OurSociety\TestSuite\Behat\Page\PoliticianProfile;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class PoliticianContext extends PageObjectContext
{
    use Traits\FixturesTrait;

    private const VIDEO_ID_EDIT = 'de7040fd-87c4-33ad-9f61-b9e835c91bb8';

    /**
     * @var PoliticianProfile
     */
    private $politicianProfile;

    /**
     * @var Login
     */
    private $login;

    public function __construct(
        Login $login,
        PoliticianProfile $politicianProfile
    ) {
        $this->login = $login;
        $this->politicianProfile = $politicianProfile;
    }

    /** @BeforeScenario */
    public function loggedInAsPolitician(BeforeScenarioScope $scope)
    {
        $this->login->loginAsPolitician();
    }

    /**
     * @Given /^I am on my profile$/
     */
    public function iAmOnMyProfile()
    {
        $this->politicianProfile->open();
    }

    /**
     * @Given /^there is a video$/
     */
    public function thereIsAVideo()
    {
        if (!$this->politicianProfile->hasFeaturedVideo()) {
            $message = sprintf('Expected to find a featured video.');

            throw new \LogicException($message);
        }
    }

    /**
     * @When /^I edit that video$/
     */
    public function iEditThatVideo()
    {
        $videoList = $this->politicianProfile->clickToEditVideos();
        $videoEditPage = $videoList->clickToEditVideo(self::VIDEO_ID_EDIT);
        $videoEditPage->setYoutubeVideoId('test');
        $videoEditPage->setAsFeatured(false);
        $videoEditPage->save();
    }

    /**
     * @Then /^the video is updated$/
     */
    public function theVideoIsUpdated()
    {
        $videoList = $this->politicianProfile->clickToEditVideos();
        $videoEditPage = $videoList->clickToEditVideo(self::VIDEO_ID_EDIT);
        $videoEditPage->assertYoutubeVideoId('test');
        $videoEditPage->assertFeatured(false);
    }
}

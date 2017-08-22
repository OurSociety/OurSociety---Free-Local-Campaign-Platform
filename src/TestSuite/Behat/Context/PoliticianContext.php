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
     * @Given /^There is a video$/
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
        $videoList->iEditThatVideo();
        //$this->visitPath(sprintf('/politician/profile/videos/edit/%s', self::VIDEO_ID_EDIT));
        //$this->assertPageAddress(sprintf('/politician/profile/videos/edit/%s', self::VIDEO_ID_EDIT));
        //$this->fillField('YouTube Video ID', 'test');
        //$this->uncheckOption('Feature This Video?');
        //$this->pressButton('Save');
    }

    /**
     * @Then /^The video is updated$/
     */
    public function theVideoIsUpdated()
    {
        $this->visitPath(sprintf('/politician/profile/videos/edit/%s', self::VIDEO_ID_EDIT));
        $this->assertPageAddress(sprintf('/politician/profile/videos/edit/%s', self::VIDEO_ID_EDIT));
        $this->assertFieldContains('YouTube Video ID', 'test');
        $this->assertCheckboxNotChecked('Feature This Video?');
    }
}

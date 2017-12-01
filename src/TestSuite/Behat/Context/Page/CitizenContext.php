<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use OurSociety\TestSuite\Behat\Context\PageContext;
use OurSociety\TestSuite\Behat\Context\Traits\AuthContextAwareTrait;
use OurSociety\TestSuite\Behat\Page;

class CitizenContext extends PageContext
{
    use AuthContextAwareTrait;

    private $dashboardPage;

    private $onboardingPage;

    public function __construct(
        Page\Citizen\Dashboard $dashboardPage,
        Page\Citizen\Onboarding $onboardingPage
    ) {
        $this->dashboardPage = $dashboardPage;
        $this->onboardingPage = $onboardingPage;
    }

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        //$environment = $scope->getEnvironment();
        //$this->guestContext = $environment->getContext(GuestContext::class);
    }

    /**
     * @Given I am on the dashboard
     */
    public function iAmOnTheDashboard()
    {
        $this->dashboardPage->open();
    }

    /**
     * @When /^I click through the tutorial screens$/
     */
    public function iClickThroughTheTutorialScreens()
    {
        $this->onboardingPage->doTutorial();
    }

    /**
     * @Given /^my selected municipality is "([^"]*)"$/
     * @throws \Behat\Mink\Exception\DriverException
     */
    public function mySelectedMunicipalityIs($municipality)
    {
        $expected = $municipality;
        $actual = $this->getAuthContext()->getIdentity()->electoral_district->name;

        if ($expected !== $actual) {
            $this->throwException(sprintf('Expected municipality to be "%s". Found "%s"', $expected, $actual));
        }
    }
}

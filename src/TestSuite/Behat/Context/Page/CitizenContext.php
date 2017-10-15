<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class CitizenContext extends PageObjectContext
{
    private $dashboardPage;

    private $guestContext;

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
}

<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Exception\DriverException;
use Cake\Log\Log;
use Muffin\Slug\Slugger\CakeSlugger;
use OurSociety\TestSuite\Behat\Context\PageContext;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class CommonContext extends PageContext
{
    protected $citizenDashboard;

    protected $home;

    protected $join;

    protected $municipalProfile;

    protected $onboarding;

    protected $root;

    protected $signIn;

    public function __construct(
        Page\Citizen\Dashboard $citizenDashboard,
        Page\Citizen\Onboarding $onboarding,
        Page\Guest\Home $home,
        Page\Guest\Join $join,
        Page\Guest\Root $root,
        Page\Guest\SignIn $signIn,
        Page\MunicipalProfile $municipalProfile
    ) {
        $this->citizenDashboard = $citizenDashboard;
        $this->home = $home;
        $this->join = $join;
        $this->municipalProfile = $municipalProfile;
        $this->onboarding = $onboarding;
        $this->root = $root;
        $this->signIn = $signIn;
    }

    /**
     * @Then /^I should see the (info|success|warning|error) message "([^"]*)"$/
     * @Then /^I should see the (info|success|warning|error) message:$/
     * @throws DriverException
     */
    public function iShouldSeeTheMessage($style, PyStringNode $message)
    {
        $actual = $this->signIn->getFlashMessage();
        $expected = $message->getRaw();
        if ($actual !== $expected) {
            $this->throwException(sprintf('Expected message "%s" but got "%s".', $expected, $actual));
        }

        $actual = $this->signIn->getFlashStyle();
        if ($actual !== $style) {
            $this->throwException(sprintf('Expected "%s" message but got "%s".', $style, $actual));
        }
    }

    /**
     * @When /^I try to access the (.+?(?= page)) page$/
     */
    public function iTryToAccessThePage(string $page)
    {
        $this->setCurrentPage($page);

        try {
            $this->getCurrentPage()->open();
        } catch (UnexpectedPageException $exception) {
            /** @noinspection CompactCanBeUsedInspection */
            Log::debug('Behat: Page could not be opened as expected', ['page' => $page, 'exception' => $exception]);
        }
    }

    /**
     * @Given /^I am on the (.+?(?= page)) page$/
     * @throws DriverException
     */
    public function iAmOnThePage(string $page)
    {
        $pageObject = $this->setCurrentPage($page);
        $pageObject->open();

        if ($pageObject->isOpen() === false) {
            $this->throwException(sprintf('Expected the "%s" page to be open.', $page));
        }
    }

    /**
     * @When /^I click "([^"]*)" in the top navigation$/
     */
    public function iClickInTheTopNavigation($linkText)
    {
        $this->getCurrentPage()->clickNavbarLink($linkText);
    }

    /**
     * @When /^I click the logo in the top navigation$/
     */
    public function iClickTheLogoInTheTopNavigation()
    {
        $this->getCurrentPage()->clickNavbarLink('OurSociety');
    }

    /**
     * @Then /^I should be on the (.+?(?= page)) page$/
     * @throws DriverException
     */
    public function iShouldBeOnThePage(string $page)
    {
        $this->setCurrentPage($page);

        if ($this->getCurrentPage()->isOpen() === false) {
            $this->throwException(sprintf('Expected the "%s" page to be open.', $page));
        }
    }

    /**
     * @When I sign out
     */
    public function iSignOut()
    {
        $this->signIn->signOut();
    }

    /**
     * @Given my browser sets a remember me cookie
     * @throws \Exception
     */
    public function myBrowserSetsARememberMeCookie()
    {
        $this->signIn->isRememberMeCookieSet();
    }

    /**
     * @Given I am on the :name municipal profile
     */
    public function iAmOnTheMunicipalProfile($municipality)
    {
        $this->page = $this->municipalProfile;
        $this->page->open([
            'municipality' => (new CakeSlugger)->slug($municipality),
        ]);
    }

    /**
     * @Then I should be on the :name municipal profile
     * @throws DriverException
     */
    public function iShouldBeOnTheMunicipalProfile(string $name)
    {
        if (
            $this->municipalProfile->isOpen([
                'municipality' => (new CakeSlugger)->slug($name),
            ]) === false
        ) {
            $this->throwException(sprintf('Expected the "%s" page to be open.', $name));
        }
    }

    /**
     * @When /^I press the "([^"]*)" button$/
     */
    public function iPressTheButton($linkText)
    {
        $this->page->pressButton($linkText);
    }

    /**
     * @Then /^I should see the "([^"]*)" button$/
     */
    public function iShouldSeeTheButton($linkText)
    {
        $this->page->hasButton($linkText);
    }
}

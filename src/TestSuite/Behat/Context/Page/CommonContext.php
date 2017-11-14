<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Mink\Exception\DriverException;
use Cake\Log\Log;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class CommonContext extends PageObjectContext
{
    private $onboarding;

    private $signIn;

    public function __construct(
        Page\Guest\SignIn $signIn,
        Page\Citizen\Onboarding $onboarding
    ) {
        $this->signIn = $signIn;
        $this->onboarding = $onboarding;
    }

    /**
     * @Then /^I should see the (info|success|warning|error) message "([^"]*)"$/
     */
    public function iShouldSeeTheMessage($style, $message)
    {
        $actual = $this->signIn->getFlashMessage();
        if ($actual !== $message) {
            $this->throwException(sprintf('Expected message "%s" but got "%s".', $message, $actual));
        }

        $actual = $this->signIn->getFlashStyle();
        if ($actual !== $style) {
            $this->throwException(sprintf('Expected "%s" message but got "%s".', $style, $actual));
        }
    }

    /**
     * @When I try to access the (!?:page.*) page
     */
    public function iTryToAccessThePage(string $page)
    {
        $page = $this->getPagePropertyName($page);

        try {
            $this->$page->open();
        } catch (UnexpectedPageException $exception) {
            /** @noinspection CompactCanBeUsedInspection */
            Log::debug('Behat: Page could not be opened as expected', ['page' => $page, 'exception' => $exception]);
        }
    }

    /**
     * @Given I am on the (!?:page.*) page
     * @Given /^I am on the "([^"]*)" page$/
     */
    public function iAmOnThePage(string $page)
    {
        $page = $this->getPagePropertyName($page);

        if ($this->$page->isOpen() === false) {
            $this->throwException(sprintf('Expected the "%s" page to be open.', $page));
        }
    }

    /**
     * @Then /^I should be on the "([^"]*)" page$/
     */
    public function iShouldBeOnThePage(string $page)
    {
        $page = $this->getPagePropertyName($page);

        if ($this->$page->isOpen() === false) {
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
     */
    public function myBrowserSetsARememberMeCookie()
    {
        $this->signIn->isRememberMeCookieSet();
    }

    private function getPagePropertyName(string $page): string
    {
        return lcfirst(str_replace(' ', '', ucwords($page)));
    }

    /**
     * Throw exception.
     *
     * Throws a `Behat\Mink\Exception` so the `Behat\MinkExtension` `show_auto` setting can work.
     *
     * @param string $message
     * @return void
     * @throws DriverException
     */
    private function throwException(string $message): void
    {
        throw new DriverException($message);
    }
}

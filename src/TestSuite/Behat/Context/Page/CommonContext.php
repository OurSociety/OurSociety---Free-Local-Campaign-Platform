<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Mink\Exception\DriverException;
use Cake\Log\Log;
use OurSociety\TestSuite\Behat\Context\PageContext;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class CommonContext extends PageContext
{
    protected $blogRedirect;

    protected $onboarding;

    protected $root;

    protected $signIn;

    public function __construct(
        Page\Citizen\Onboarding $onboarding,
        Page\Guest\BlogRedirect $blogRedirect,
        Page\Guest\Root $root,
        Page\Guest\SignIn $signIn
    ) {
        /** @noinspection UnusedConstructorDependenciesInspection */
        $this->blogRedirect = $blogRedirect;
        /** @noinspection UnusedConstructorDependenciesInspection */
        $this->onboarding = $onboarding;
        /** @noinspection UnusedConstructorDependenciesInspection */
        $this->root = $root;
        /** @noinspection UnusedConstructorDependenciesInspection */
        $this->signIn = $signIn;
    }

    /**
     * @Then /^I should see the (info|success|warning|error) message "([^"]*)"$/
     * @throws DriverException
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

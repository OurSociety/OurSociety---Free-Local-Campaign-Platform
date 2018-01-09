<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\DriverException;
use Cake\Log\LogTrait;
use Muffin\Slug\Slugger\CakeSlugger;
use OurSociety\Model\Users;
use OurSociety\TestSuite\Behat\Context\Traits\{
    FixturesTrait
};
use OurSociety\TestSuite\Behat\Page\PageFactory;
use Psr\Log\LogLevel;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectAware;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory as PageObjectFactory;

class PageContext implements Context, PageObjectAware
{
    use FixturesTrait;
    Use LogTrait;

    /**
     * @var \OurSociety\TestSuite\Behat\Page\PageFactory
     */
    protected $pages;

    /**
     * @When I try to access the :page page
     */
    public function iTryToAccessThePage(string $page)
    {
        try {
            $this->pages->getPage($page)->open();
        } catch (UnexpectedPageException $exception) {
            $this->log('Behat: Page could not be opened as expected', LogLevel::DEBUG, [
                'currentPage' => $this->pages->getCurrentPage(),
                'exception' => $exception,
            ]);
        }
    }

    /**
     * @Then /^I should see the (info|success|warning|error) message "([^"]*)"$/
     * @Then /^I should see the (info|success|warning|error) message:$/
     * @throws DriverException
     */
    public function iShouldSeeTheMessage(string $style, $message)
    {
        $page = $this->pages->getCurrentPage();

        if ($page->isLoadedUsingBrowserDriver() === false) {
            return;
        }

        $actual = $page->getFlashMessage();
        $expected = $message instanceof PyStringNode ? $message->getRaw() : $message;
        if ($actual !== $expected) {
            $this->throwException(sprintf('Expected message "%s" but got "%s".', $expected, $actual));
        }

        $actual = $page->getFlashStyle();
        if ($actual !== $style) {
            $this->throwException(sprintf('Expected "%s" message but got "%s".', $style, $actual));
        }
    }

    /**
     * @Given I am on the :page page
     * @throws DriverException
     */
    public function iAmOnThePage(string $page)
    {
        $currentPage = $this->pages->getPage($page);
        $currentPage->open();

        if ($currentPage->isOpen() === false) {
            $this->throwException(sprintf('Expected the "%s" page to be open.', $page));
        }
    }

    /**
     * @When /^I click "([^"]*)" in the top navigation$/
     */
    public function iClickInTheTopNavigation($linkText)
    {
        $this->pages->getCurrentPage()->clickNavbarLink($linkText);
    }

    /**
     * @When /^I click the logo in the top navigation$/
     */
    public function iClickTheLogoInTheTopNavigation()
    {
        $this->pages->getCurrentPage()->clickNavbarLink('OurSociety');
    }

    /**
     * @Then I should be on the :page page
     * @Then I should be on the :page page with:
     * @throws DriverException
     */
    public function iShouldBeOnThePage(string $page)
    {
        if ($this->pages->getPage($page)->isOpen() === false) {
            $this->throwException(sprintf('Expected the "%s" page to be open.', $page));
        }
    }

    /**
     * @When I sign out
     */
    public function iSignOut()
    {
        $this->pages->getCurrentPage()->signOut();
    }

    /**
     * @Given I am on the :name municipal profile
     */
    public function iAmOnTheMunicipalProfile($municipality)
    {
        $this->pages->getMunicipalProfilePage()->open([
            'municipality' => (new CakeSlugger)->slug($municipality),
        ]);
    }

    /**
     * @Then I should be on the :municipality municipal profile
     * @throws DriverException
     */
    public function iShouldBeOnTheMunicipalProfile(string $municipality)
    {
        $isOpen = $this->pages->getMunicipalProfilePage()->isOpen([
            'municipality' => (new CakeSlugger)->slug($municipality),
        ]);

        if ($isOpen === false) {
            $this->throwException(sprintf('Expected the "%s" municipal profile to be open.', $municipality));
        }
    }

    /**
     * @param PageObjectFactory $pageObjectFactory
     *
     * @return null
     */
    public function setPageObjectFactory(PageObjectFactory $pageObjectFactory): void
    {
        $this->pages = PageFactory::instance($pageObjectFactory);
    }

    /**
     * @Given my browser sets a remember me cookie
     * @throws \Exception
     */
    public function myBrowserSetsARememberMeCookie()
    {
        $this->pages->getSignInPage()->isRememberMeCookieSet();
    }

    /**
     * @When I press the :button button
     */
    public function iPressTheButton(string $button): void
    {
        $this->pages->getCurrentPage()->pressButton($button);
    }

    /**
     * @Then /^I should see the "([^"]*)" button$/
     */
    public function iShouldSeeTheButton($linkText)
    {
        $this->pages->getCurrentPage()->hasButton($linkText);
    }

    /**
     * @Given I am on the representative profile for :name
     */
    public function iAmOnTheRepresentativeProfileFor(string $name): void
    {
        $this->pages->getRepresentativeProfilePage()->open([
            'representative' => Users::instance()->getRepresentativeSlugByName($name),
        ]);
    }

    /**
     * @Then I should see a listing containing the following records:
     */
    public function iShouldSeeAListingContainingTheFollowingRecords(TableNode $table)
    {
        $this->pages->getListingComponentPage()->containsRecords($table);
    }

    /**
     * @When I click the :button button on the :record record
     */
    public function iClickTheButtonOnTheRecord(string $button, string $record)
    {
        $this->pages->getListingComponentPage()->edit($record);
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
    protected function throwException(string $message): void
    {
        throw new DriverException($message);
    }
}

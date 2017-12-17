<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\DriverException;
use Cake\Log\Log;
use Muffin\Slug\Slugger\CakeSlugger;
use OurSociety\Model\Entity\User;
use OurSociety\ORM\TableRegistry;
use OurSociety\TestSuite\Behat\Context\PageContext;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;

class CommonContext extends PageContext
{
    protected $citizenDashboard;

    protected $home;

    protected $join;

    /**
     * @var Page\Component\Listing
     */
    protected $listing;

    protected $municipalProfile;

    protected $onboarding;

    protected $representativeProfile;

    protected $root;

    protected $signIn;

    public function __construct(
        Page\Citizen\Dashboard $citizenDashboard,
        Page\Citizen\Onboarding $onboarding,
        Page\Component\Listing $listing,
        Page\Guest\Home $home,
        Page\Guest\Join $join,
        Page\Guest\MunicipalProfile $municipalProfile,
        Page\Guest\RepresentativeProfile $representativeProfile,
        Page\Guest\Root $root,
        Page\Guest\SignIn $signIn,
        Page\Page $page,
        Page\Politician\Profile\AwardList $awardList
    ) {
        $this->awardList = $awardList;
        $this->citizenDashboard = $citizenDashboard;
        $this->home = $home;
        $this->join = $join;
        $this->listing = $listing;
        $this->municipalProfile = $municipalProfile;
        $this->onboarding = $onboarding;
        $this->page = $page;
        $this->representativeProfile = $representativeProfile;
        $this->root = $root;
        $this->signIn = $signIn;
    }

    /**
     * @Then /^I should see the (info|success|warning|error) message "([^"]*)"$/
     * @Then /^I should see the (info|success|warning|error) message:$/
     * @throws DriverException
     */
    public function iShouldSeeTheMessage(string $style, $message)
    {
        if ($this->page->isLoadedUsingBrowserDriver() === false) {
            return;
        }

        $actual = $this->page->getFlashMessage();
        $expected = $message instanceof PyStringNode ? $message->getRaw() : $message;
        if ($actual !== $expected) {
            $this->throwException(sprintf('Expected message "%s" but got "%s".', $expected, $actual));
        }

        $actual = $this->page->getFlashStyle();
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
     * @When I press the :button button
     */
    public function iPressTheButton(string $button): void
    {
        $this->page->pressButton($button);
    }

    /**
     * @Then /^I should see the "([^"]*)" button$/
     */
    public function iShouldSeeTheButton($linkText)
    {
        $this->page->hasButton($linkText);
    }

    /**
     * @Given I am on the representative profile for :name
     */
    public function iAmOnTheRepresentativeProfileFor(string $name): void
    {
        $table = TableRegistry::get('Users');

        /** @var User $representative */
        $representative = $table->find()->select([
            $table->aliasField('slug'),
        ])->where([
            $table->aliasField('name') => $name,
            $table->aliasField('role') => User::ROLE_POLITICIAN,
        ])->firstOrFail();

        $this->page = $this->representativeProfile;
        $this->page->open([
            'representative' => $representative->slug,
        ]);
    }

    /**
     * @Then I should see a listing containing the following records:
     */
    public function iShouldSeeAListingContainingTheFollowingRecords(TableNode $table)
    {
        $this->listing->containsRecords($table);
    }

    /**
     * @When I click the :button button on the :record record
     */
    public function iClickTheButtonOnTheRecord(string $button, string $record)
    {
        $this->listing->edit($record);
    }
}

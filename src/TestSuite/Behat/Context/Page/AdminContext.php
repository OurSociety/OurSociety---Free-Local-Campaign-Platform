<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Page;

use Behat\Gherkin\Node\TableNode;
use OurSociety\ORM\TableRegistry;
use OurSociety\TestSuite\Behat\Page;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class AdminContext extends PageObjectContext
{
    /**
     * @var Page\Admin\ListUsersPage
     */
    private $listUsersPage;

    /**
     * @var Page\Login
     */
    private $loginPage;

    public function __construct(
        Page\Login $loginPage,
        Page\Admin\ListUsersPage $listUsersPage
    ) {
        $this->listUsersPage = $listUsersPage;
        $this->loginPage = $loginPage;
    }

    /**
     * @Given the following :modelName:
     */
    public function theFollowingUsers(string $modelName, TableNode $table)
    {
        $repository = TableRegistry::get($modelName);

        collection($table->getHash())->each(function($row) use ($repository) {
            $repository->upsert($row);
        });
    }

    /**
     * @Given I am logged in as an admin
     */
    public function iAmLoggedInAsAnAdmin()
    {
        $this->loginPage->loginAsAdmin();
    }

    /**
     * @When I visit the user list page
     */
    public function iVisitTheUserListPage()
    {
        $this->listUsersPage->open();
    }

    /**
     * @Then I should see the following records listed:
     */
    public function iShouldSeeTheFollowingRecordsListed(TableNode $table)
    {
        $this->listUsersPage->assertRecords($table);
    }

    /**
     * @When /^I delete "([^"]*)"$/
     */
    public function iDelete($arg1)
    {
        throw new PendingException();
    }
}

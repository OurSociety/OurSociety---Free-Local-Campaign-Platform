<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureInjector;
use OurSociety\Model\Table\AppTable;
use OurSociety\TestSuite\Behat\Page as Page;
use OurSociety\TestSuite\Fixture\FixtureManager;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

/**
 * Admin context.
 *
 * Used for all features with the admin role (ie. "As an admin").
 */
class AdminContext extends PageObjectContext implements Context
{
    private $fixtureInjector;
    private $fixture;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        /** @noinspection PhpIncludeInspection */
        require_once sprintf('%s/tests/bootstrap.php', dirname(__DIR__, 5));
        ConnectionManager::alias('test', 'default');

        $this->fixtureInjector = new FixtureInjector(new FixtureManager);
        $this->fixture = new BddAllFixture();
    }

    /** @BeforeScenario */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        $this->fixtureInjector->startTest($this->fixture);
    }

    /** @AfterScenario */
    public function afterScenario(AfterScenarioScope $scope)
    {
        $this->fixtureInjector->endTest($this->fixture, time());
    }

    /**
     * @Given the following :modelName:
     */
    public function theFollowingUsers(string $modelName, TableNode $table)
    {
        /** @var AppTable $repository */
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
        /** @var Page\Login $loginPage */
        $loginPage = $this->getPage(Page\Login::class);
        $loginPage->loginAsAdmin();
    }

    /**
     * @When I visit the user list page
     */
    public function iVisitTheUserListPage()
    {
        /** @var Page\Admin\ListUsersPage $listUsersPage */
        $listUsersPage = $this->getPage(Page\Admin\ListUsersPage::class);
        $listUsersPage->open();
    }

    /**
     * @Then I should see the following users:
     */
    public function iShouldSeeTheFollowingUsers(TableNode $table)
    {
        /** @var Page\Admin\ListUsersPage $listUsersPage */
        $listUsersPage = $this->getPage(Page\Admin\ListUsersPage::class);

        expect($listUsersPage->hasTableItems($table))->shouldEqual(true);
    }
}

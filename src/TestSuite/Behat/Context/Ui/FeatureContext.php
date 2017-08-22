<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\Fixture\FixtureInjector;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use OurSociety\TestSuite\Fixture\FixtureManager;
use OurSociety\TestSuite\TestCase;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        require_once dirname(__DIR__, 5) . '/tests/bootstrap.php';
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

    ///**
    // * Take screenshot when step fails.
    // * Works only with Selenium2Driver.
    // *
    // * @AfterStep
    // */
    //public function takeScreenshotAfterFailedStep(AfterStepScope $event) {
    //    /** @var ExecutedStepResult $testResult */
    //    $testResult = $event->getTestResult();
    //    if ($testResult->getResultCode() === ExecutedStepResult::FAILED) {
    //        $driver = $this->getSession()->getDriver();
    //        if ($driver instanceof Selenium2Driver) {
    //            $step = $event->getStep();
    //            //$id = $step->getParent()->getTitle() . '.' . $step->getType() . ' ' . $step->getText();
    //            $id = $step->getType() . ' ' . $step->getText();
    //            $fileName = 'Fail.'.preg_replace('/[^a-zA-Z0-9-_\.]/','_', $id) . '.jpg';
    //            file_put_contents($fileName, $driver->getScreenshot());
    //        }
    //    }
    //}

    /**
     * @Given a citizen named :name
     */
    public function aCitizenNamed($name)
    {
        $table = TableRegistry::get('Users');
        $table->saveOrFail($table->newEntity([
            'name' => $name,
            'email' => sprintf('%s@example.com', Inflector::dasherize(Inflector::camelize($name))),
            'password' => Security::randomBytes(42),
        ]));
    }

    /**
     * @Given the available questions:
     */
    public function theAvailableQuestions(TableNode $table)
    {
        dd($table->getHash());
        $table = TableRegistry::get('Users');
        $table->saveOrFail($table->newEntity([
            'name' => $name,
            'email' => sprintf('%s@example.com', Inflector::dasherize(Inflector::camelize($name))),
            'password' => Security::randomBytes(42),
        ]));
    }

    /**
     * @Then I take a screenshot
     */
    public function iTakeAScreenshot()
    {
        throw new \Exception('stop!');
    }

    /**
     * @Then /^I should see an? (error|success|warning) message$/
     * @Then /^I should see an? (error|success|warning) message that says "([^"]*)"$/
     */
    public function iShouldSeeAMessage(string $messageType, ?string $message = null): void
    {
        $class = '.alert-' . $messageType;
        $this->assertElementOnPage($class);
        if ($message !== null) {
            $this->assertElementContainsText($class, $message);
        }
    }
}

class BddAllFixture extends TestCase {
    public $fixtures = [
        //'Categories' => 'app.categories',
        //'Articles'   => 'app.articles',
        'Users'      => 'app.users',
        //'Categories' => 'app.categories'
    ];
}

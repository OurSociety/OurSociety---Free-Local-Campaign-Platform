<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Cake\Datasource\ConnectionManager;
use OurSociety\TestSuite\Fixture\DatabaseFixture;

trait FixturesTrait
{
    /**
     * @var DatabaseFixture
     */
    private static $fixtureClass;

    /** @BeforeSuite */
    public static function initFixtures(BeforeSuiteScope $scope): void
    {
        /** @noinspection PhpIncludeInspection */
        require_once sprintf('%s/tests/bootstrap.php', dirname(__DIR__, 5));
        ConnectionManager::alias('test', 'default');
        self::$fixtureClass = new DatabaseFixture();
    }

    /** @BeforeScenario */
    public function refreshFixtures(BeforeScenarioScope $scope): void
    {
        self::$fixtureClass->loadTestDatabase();
    }
}

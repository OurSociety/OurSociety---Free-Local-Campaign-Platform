<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\Traits;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\ORM\TableRegistry;
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

    /**
     * @Given a representative named :name
     */
    public function aRepresentativeNamed(string $name): void
    {
        $table = TableRegistry::get('Users');
        $table->find()->where([
            $table->aliasField('name') => $name,
            $table->aliasField('role') => User::ROLE_POLITICIAN,
        ])->firstOrFail();
    }

    /**
     * @Given an award named :award assigned to :user
     */
    public function anAwardNamedAssignedTo(string $award, string $user): void
    {
        $table = TableRegistry::get('Awards');
        $table->find()->where([
            $table->aliasField('name') => $award,
        ])->matching('Politicians', function (Query $query) use ($table, $user): Query {
            return $query->where([
                $table->Politicians->aliasField('name') => $user,
            ]);
        })->firstOrFail();
    }
}

<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite\Fixture;

use Cake\TestSuite\Fixture as Cake;

/**
 * Application test fixture manager.
 */
class FixtureManager extends Cake\FixtureManager
{
    public function load($test): void
    {
        /** @noinspection MissingIssetImplementationInspection */
        if (empty($test->fixtures)) {
            return;
        }

        $fixtures = $test->fixtures;
        if (empty($fixtures) || !$test->autoFixtures) {
            return;
        }

        $database = new DatabaseFixture;
        $database->loadTestDatabase();
    }

    //public function unload($test): void
    //{
        // NO TRUNCATE: Keep data around after tests pass/fail so we can inspect the application state.
    //}

    //public function shutDown(): void
    //{
        // NO DROP: Keep tables around after tests pass/fail so we can inspect the application state.
    //}
}

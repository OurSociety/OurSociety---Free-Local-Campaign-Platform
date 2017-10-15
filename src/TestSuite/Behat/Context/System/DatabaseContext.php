<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\System;

use Behat\Behat\Context\Context;
use OurSociety\ORM\TableRegistry;

class DatabaseContext implements Context
{
    /**
     * @Given /^there are (\d+) "([^"]*)"s$/
     * Example: Given there are 7 "Muffin"s
     */
    public function thereAreSomeNumberOf(int $num, string $table): void
    {
        TableRegistry::get($table)->save($table::example());
    }
}

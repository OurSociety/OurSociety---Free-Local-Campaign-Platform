<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use Cake\ORM\TableRegistry;
use Cake\TestSuite as Cake;

class TestCase extends Cake\TestCase
{
    use Traits\FixturesTrait;
    use Traits\AssertionsTrait;

    public function setUp(): void
    {
        parent::setUp();

        TableRegistry::clear();
    }
}

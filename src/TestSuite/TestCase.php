<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        TableRegistry::clear();
    }
}

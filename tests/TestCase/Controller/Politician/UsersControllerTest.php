<?php
declare(strict_types = 1);

namespace OurSociety\Test\TestCase\Controller\Politician;

use OurSociety\TestSuite\IntegrationTestCase;

class UsersControllerTest extends IntegrationTestCase
{
    public function testRegister(): void
    {
        $this->get(['_name' => 'politician:register']);
        $this->assertResponseOk();
        $this->assertResponseContains('Account Details');
        $this->assertResponseContains('Home Address');
        $this->assertResponseContains('Birth Information');
    }
}

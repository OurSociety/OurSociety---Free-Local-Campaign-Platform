<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\System;

use Behat\Mink\Exception\DriverException;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\ORM\TableRegistry;
use OurSociety\TestSuite\Behat\Context\Traits\CurrentPageAwareTrait;
use OurSociety\TestSuite\Behat\Page\Guest\SignIn;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class AuthContext extends PageObjectContext
{
    use CurrentPageAwareTrait;

    /**
     * @var SignIn
     */
    private $signIn;

    /**
     * @var User
     */
    private $identity;

    public function __construct(
        SignIn $login
    ) {
        $this->signIn = $login;
    }

    /**
     * @Given I am signed in as :name
     */
    public function iAmSignedInAs(string $name): void
    {
        $this->identity = $this->findUserByName($name);

        $this->signIn->open();
        $this->signIn->signInAs($this->identity->email, 'democracy');
    }

    public function getIdentity(): User
    {
        return $this->identity;
    }

    /**
     * @Given I have no unread notifications
     * @Then I should have no unread notifications
     * @Then I should have :count unread notifications
     */
    public function assertNotificationCount(int $expected = null)
    {
        $expected = $expected ?? 0;
        $actual = $this->signIn->getUnreadNotificationCount();

        if ($expected !== $actual) {
            throw new DriverException(sprintf('Expected %d unread notifications. Got %d', $expected, $actual));
        }
    }

    private function findUserByName($name): User
    {
        /** @var UsersTable $usersTable */
        $usersTable = TableRegistry::get('Users');
        $query = $usersTable->findByName($name)->find('auth');

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $query->firstOrFail();
    }
}

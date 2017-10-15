<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Context\System;

use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\ORM\TableRegistry;
use OurSociety\TestSuite\Behat\Page\Guest\SignIn;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class AuthContext extends PageObjectContext
{
    /**
     * @var SignIn
     */
    private $signIn;

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
        $user = $this->findUserByName($name);

        $this->signIn->open();
        $this->signIn->signInAs($user->email, 'democracy');
    }

    private function findUserByName($name): User
    {
        /** @var UsersTable $usersTable */
        $usersTable = TableRegistry::get('Users');
        $query = $usersTable->findByName($name);

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $query->firstOrFail();
    }
}

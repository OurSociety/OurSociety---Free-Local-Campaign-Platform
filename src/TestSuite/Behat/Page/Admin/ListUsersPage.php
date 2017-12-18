<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Admin;

use OurSociety\TestSuite\Behat\Page\Crud;

/**
 * Index page.
 */
class ListUsersPage extends Crud\IndexPage
{
    protected $elements = [
        'Search form' => 'form#search',
        'Navigation' => ['css' => '.header div.navigation'],
        'Article list' => ['xpath' => '//*[contains(@class, "content")]//ul[contains(@class, "articles")]'],
        'User list' => ['css' => '.scaffold-action-index .table'],
    ];

    protected function getRouteName(): string
    {
        return 'admin:users';
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Admin;

/**
 * Index page.
 */
class ListUsersPage extends Crud\IndexPage
{
    protected $path = '/admin/users';

    protected $elements = [
        'Search form' => 'form#search',
        'Navigation' => ['css' => '.header div.navigation'],
        'Article list' => ['xpath' => '//*[contains(@class, "content")]//ul[contains(@class, "articles")]'],
        'User list' => ['css' => '.scaffold-action-index .table'],
    ];
}
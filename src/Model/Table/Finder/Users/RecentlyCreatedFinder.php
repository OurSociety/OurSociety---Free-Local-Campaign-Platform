<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;
use OurSociety\Model\Table\UsersTable;

class RecentlyCreatedFinder extends Finder
{
    /**
     * {@inheritdoc}. Find recently created.
     *
     * Finds the recent created users by their registration date.
     */
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->orderDesc('Users.created')
            ->limit(UsersTable::LIMIT_DASHBOARD);
    }
}

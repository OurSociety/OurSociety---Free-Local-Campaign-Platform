<?php
declare(strict_types = 1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;
use OurSociety\Model\Table\UsersTable;

class RecentlyActiveFinder extends Finder
{
    /**
     * Find recently active.
     *
     * Finds the recently active users by their last seen date.
     *
     * @param Query $query The original query.
     * @return Query The updated query.
     */
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->where(['Users.last_seen IS NOT' => null])
            ->orderDesc('Users.last_seen')
            ->limit(UsersTable::LIMIT_DASHBOARD);
    }
}

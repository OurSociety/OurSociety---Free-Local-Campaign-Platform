<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Notifications;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class IsUnreadFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->where([
            'Notifications.seen IS' => null,
        ]);
    }
}

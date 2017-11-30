<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Notifications;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenShowActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query->select([
            'Notifications.id',
            'Notifications.title',
            'Notifications.body',
            'Notifications.seen',
            'Notifications.created',
        ]);
    }
}

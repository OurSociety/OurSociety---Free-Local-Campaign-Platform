<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Notifications;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

abstract class ForCommonListActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $user = $this->getIdentity($options);

        return $query
            ->select([
                'Notifications.id',
                'Notifications.title',
                'Notifications.seen',
                'Notifications.created',
            ])
            ->where([
                'Notifications.user_id' => $user->id,
            ])
            ->orderDesc('Notifications.created');
    }
}

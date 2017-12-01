<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Notifications;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenListActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        if (!isset($options['user'])) {
            throw new \InvalidArgumentException('Expected user option');
        }

        /** @var User $user */
        $user = $options['user'];

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

<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Users;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class AuthFinder extends Finder
{
    private const LIMIT_NOTIFICATIONS = 5;

    /**
     * {@inheritdoc}. Custom finder for AuthComponent.
     *
     * Used by the AuthComponent to get all the authenticated user's data.
     *
     * TODO: Return associated information as it becomes known, or remove method if never used.
     */
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->contain([
                'ElectoralDistricts' => function (Query $query): Query {
                    return $query->select([
                        'ElectoralDistricts.id',
                        'ElectoralDistricts.slug',
                        'ElectoralDistricts.name',
                        'ElectoralDistricts.article_factcheck_count',
                        'ElectoralDistricts.article_year_count',
                        'ElectoralDistricts.citizen_count',
                        'ElectoralDistricts.politician_count',
                    ]);
                },
                'Notifications' => function (Query $query): Query {
                    return $query
                        ->select([
                            'Notifications.id',
                            'Notifications.user_id',
                            'Notifications.title',
                            'Notifications.seen',
                            'Notifications.created',
                        ])
                        ->orderDesc('Notifications.created')
                        ->limit(self::LIMIT_NOTIFICATIONS);
                },
            ]);
    }
}

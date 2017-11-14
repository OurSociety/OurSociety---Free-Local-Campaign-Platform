<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Reports;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminViewActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                'Reports.id',
                'Reports.question_id',
                'Reports.user_id',
                'Reports.body',
                'Reports.done',
                'Reports.created',
                'Reports.modified',
            ])
            ->contain([
                'Questions' => function (Query $query) {
                    return $query->select([
                        'Questions.id',
                        'Questions.question',
                    ]);
                },
                'Users' => function (Query $query) {
                    return $query->select([
                        'Users.slug',
                        'Users.name',
                    ]);
                },
            ])
            ->orderDesc('Reports.created')
            ->orderDesc('Reports.done');
    }
}

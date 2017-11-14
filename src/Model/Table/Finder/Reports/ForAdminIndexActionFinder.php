<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Reports;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminIndexActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                'Reports.id',
                'Reports.done',
                'Reports.created',
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
            ->orderDesc('Reports.done')
            ->orderDesc('Reports.created');
    }
}

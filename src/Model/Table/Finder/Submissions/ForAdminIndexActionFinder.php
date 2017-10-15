<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Submissions;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminIndexActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                'Submissions.id',
                'Submissions.done',
                'Submissions.created',
            ])
            ->contain([
                'Users' => function (Query $query) {
                    return $query->select([
                        'Users.slug',
                        'Users.name',
                    ]);
                },
            ])
            ->orderDesc('Submissions.done')
            ->orderDesc('Submissions.created');
    }
}

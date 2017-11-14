<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Submissions;

use Cake\ORM\Query;
use OurSociety\Model\Table\Finder\Finder;

class ForAdminViewActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        return $query
            ->select([
                'Submissions.id',
                'Submissions.body',
                'Submissions.done',
                'Submissions.created',
                'Submissions.modified',
            ])
            ->contain([
                'Users' => function (Query $query) {
                    return $query->select([
                        'Users.slug',
                        'Users.name',
                    ]);
                },
            ])
            ->orderDesc('Submissions.created')
            ->orderDesc('Submissions.done');
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Answers;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenListActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        /** @var User $identity */
        $identity = $options['identity'];

        return $query
            ->select([
                'Answers.id',
                'Answers.answer',
                'Answers.importance',
                'Answers.created',
            ])
            ->contain([
                'Questions' => function (Query $query) {
                    return $query
                        ->contain([
                            'Categories' => function (Query $query) {
                                return $query
                                    ->select([
                                        'Categories.slug',
                                        'Categories.name',
                                    ]);
                            },
                        ])
                        ->select([
                            'Questions.id',
                            'Questions.question',
                        ]);
                },
                'Users' => function (Query $query) {
                    return $query
                        ->select([
                            'Users.slug',
                            'Users.name',
                        ]);
                },
            ])
            ->where([
                'Answers.user_id' => $identity->id,
            ])
            ->orderDesc('Answers.created');
    }
}

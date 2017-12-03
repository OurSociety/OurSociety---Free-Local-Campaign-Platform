<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Answers;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;

class ForCitizenEditActionFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        /** @var User $identity */
        $identity = $options['identity'];

        return $query
            ->select([
                $this->aliasField($query, 'id'),
                $this->aliasField($query, 'answer'),
                $this->aliasField($query, 'importance'),
                $this->aliasField($query, 'created'),
            ])
            ->contain([
                'Questions' => function (Query $query) {
                    return $query
                        ->contain([
                            'Categories' => function (Query $query) {
                                return $query
                                    ->select([
                                        $this->aliasField($query, 'slug'),
                                        $this->aliasField($query, 'name'),
                                    ]);
                            },
                        ])
                        ->select([
                            $this->aliasField($query, 'id'),
                            $this->aliasField($query, 'question'),
                            $this->aliasField($query, 'type'),
                        ]);
                },
                'Users' => function (Query $query) {
                    return $query
                        ->select([
                            $this->aliasField($query, 'id'),
                            $this->aliasField($query, 'slug'),
                            $this->aliasField($query, 'name'),
                        ]);
                },
            ])
            ->where([
                $this->aliasField($query, 'user_id') => $identity->id,
            ])
            ->orderDesc(
                $this->aliasField($query, 'created')
            );
    }
}

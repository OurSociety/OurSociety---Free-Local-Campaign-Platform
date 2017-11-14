<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Questions;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\Finder\Finder;
use OurSociety\Model\Table\QuestionsTable;

/**
 * BatchFinder.
 *
 * @property QuestionsTable $table
 */
class BatchFinder extends Finder
{
    public function __invoke(Query $query, array $options = []): Query
    {
        $user = $options['user'] ?? null;

        if (!$user instanceof User) {
            throw new \InvalidArgumentException('User required');
        }

        $whereUserHasAnsweredThisQuestion = function (Query $query) use ($user) {
            return $query->where([
                $this->table->Answers->aliasField('user_id') => $user->id,
            ]);
        };

        return $query
            ->notMatching('Answers', $whereUserHasAnsweredThisQuestion)
            ->where([
                $this->table->aliasField('level') => $user->level,
            ])
            ->contain([
                'Categories' => ['fields' => ['slug', 'name']],
            ])
            ->order([
                $this->table->aliasField('position'),
                defined('SEED') ? sprintf('RAND(%s)', SEED) : 'RAND()',
            ]);
    }
}

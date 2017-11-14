<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\ORM\Query;
use OurSociety\Model\Entity\User;

class Questions extends Model
{
    /**
     * @var self
     */
    private static $instance;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function getLevelQuestionTotal(User $user): int
    {
        return $this->repository->find()->where([
            sprintf('%s <=', $this->repository->aliasField('level')) => $user->level,
        ])->count();
    }

    public function getCount(): int
    {
        return $this->repository->find()->count();
    }

    public function getLevelForUser(User $user): int
    {
        return $this->repository->find()
            ->select(['Questions.level'])
            ->where(['Questions.level <>' => 0])
            ->notMatching('Answers', function (Query $query) use ($user): Query {
                return $query->where(['Answers.user_id' => $user->id]);
            })
            ->firstOrFail()
            ->level;
    }
}

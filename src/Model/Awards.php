<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\ORM\Query;

class Awards extends Model
{
    /**
     * @var self
     */
    private static $instance;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function hasAwardAssignedTo($award, $user)
    {
        return $this->repository->find()->where([
            $this->repository->aliasField('name') => $award,
        ])->matching('Politicians', function (Query $query) use ($user): Query {
            return $query->where([
                $this->repository->Politicians->aliasField('name') => $user,
            ]);
        })->firstOrFail();
    }
}

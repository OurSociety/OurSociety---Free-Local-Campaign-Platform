<?php
declare(strict_types=1);

namespace OurSociety\Model;

use OurSociety\Model\Entity\User;

class Answers extends Model
{
    /**
     * @var self
     */
    private static $instance;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function getCountForUser(User $user): int
    {
        return $this->repository->find()->where(['Answers.user_id' => $user->id])->count();
    }
}

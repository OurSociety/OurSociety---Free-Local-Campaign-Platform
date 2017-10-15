<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;
use OurSociety\Model\Entity\User;

class Users extends Model
{
    /**
     * @var self
     */
    private static $instance;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function getAnswers(User $user): ResultSetInterface
    {
        return $this->loadModel('Answers')
            ->find()
            ->contain(['Questions'])
            ->where(['Answers.user_id' => $user->id])
            ->orderDesc('Questions.modified')
            ->all();
    }

    public function getCategoriesForPoliticianDashboard(User $user): ResultSetInterface
    {
        return $this->loadModel('CategoriesUsers')
            ->find()
            ->select([
                'CategoriesUsers.answer_count',
            ])
            ->contain([
                'Categories' => function (Query $query) {
                    return $query->select([
                        'Categories.name',
                        'Categories.question_count',
                    ]);
                },
            ])
            ->where(['CategoriesUsers.user_id' => $user->id])
            ->orderAsc('Categories.name')
            ->all();
    }

    public function setLocation(User $user, string $locationId): void
    {
        $this->saveField($user, 'electoral_district_id', $locationId);
    }

    public function recalculateAnswerCountAndLevel(User $user): void
    {
        $user->answer_count = Answers::instance()->getCountForUser($user);
        $user->level = Questions::instance()->getLevelForUser($user);

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $this->repository->saveOrFail($user);
    }
}

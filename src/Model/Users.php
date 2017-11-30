<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\Datasource\ResultSetInterface;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use OurSociety\Model\Entity\Notification;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\NotificationsTable;

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
            ->select(['CategoriesUsers.answer_count'])
            ->contain([
                'Categories' => function (Query $query): Query {
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
        $this->repository->saveOrFail($this->repository->patchEntity($user, [
            'answer_count' => Answers::instance()->getCountForUser($user),
            'level' => Questions::instance()->getLevelForUser($user),
        ]));
    }

    public function notifyUser(User $user, string $title, string $body): void
    {
        /** @var NotificationsTable $notifications */
        $notifications = $this->loadModel('Notifications');
        $notification = $notifications->newEntity(['user_id' => $user->id, 'title' => $title, 'body' => $body]);

        /** @var Notification $notification */
        $notification = $notifications->saveOrFail($notification);

        (new Email('default'))
            //->setFrom(['me@example.com' => 'My Site'])
            ->setTo([$user->email => $user->name])
            ->setSubject($notification->title)
            ->send($notification->body);
    }

    /**
     * @return string[] List of UUIDs.
     */
    public function getAdminUsers(): ResultSetInterface
    {
        return $this->loadModel()
            ->find()
            ->select(['Users.id', 'Users.email', 'Users.name'])
            ->where(['Users.role' => User::ROLE_ADMIN])
            ->all();
    }
}

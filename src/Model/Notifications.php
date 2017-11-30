<?php
declare(strict_types=1);

namespace OurSociety\Model;

use Cake\I18n\Time;
use OurSociety\Model\Entity\Notification;

class Notifications extends Model
{
    /**
     * @var self
     */
    private static $instance;

    public static function instance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function markAsRead(Notification $notification): void
    {
        if ($notification->isMarkedAsRead()) {
            return;
        }

        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $notification = $this->repository->patchEntity($notification, [
            'seen' => Time::now(),
            'user_id' => $notification->user_id ?? $notification->user->id,
        ]);

        $this->repository->saveOrFail($notification);
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Action\Common\Notifications;

use Cake\Datasource\EntityInterface;
use OurSociety\Action\ViewAction;
use OurSociety\Model\Entity\Notification;
use OurSociety\Model\Notifications;

class ShowAction extends ViewAction
{
    protected function afterFind(EntityInterface $record): void
    {
        /** @var Notification $notification */
        $notification = $record;

        Notifications::instance()->markAsRead($notification);

        $this->refreshIdentity(); // Forces update of notification menu UI.
    }
}

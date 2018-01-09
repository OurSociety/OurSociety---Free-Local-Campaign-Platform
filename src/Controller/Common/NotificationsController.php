<?php
declare(strict_types=1);

namespace OurSociety\Controller\Common;

use OurSociety\Controller\AppController;

/**
 * Notifications controller.
 *
 * Shared by citizen and representative routes.
 *
 * @see \OurSociety\Controller\Citizen\NotificationsController
 * @see \OurSociety\Controller\Politician\NotificationsController
 */
abstract class NotificationsController extends AppController
{
}

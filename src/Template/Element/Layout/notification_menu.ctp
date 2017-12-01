<?php
/**
 * @var \OurSociety\View\AppView $this The view.
 * @var \OurSociety\Model\Entity\User $identity The identity.
 */

$notifications = $identity->notifications;
$notificationCount = count($notifications);
$unreadNotificationCount = $identity->printUnreadNotificationCount();
$hasUnreadNotifications = $unreadNotificationCount > 0;
?>

<div id="notificationMenu" class="text-nowrap">
    <a class="nav-link dropdown-toggle" href="#" id="notificationMenuToggle"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= $this->Html->icon('bell-o') ?>
        <?= $this->Html->badge($unreadNotificationCount, [
            'class' => ['badge-pill'],
            'type' => $hasUnreadNotifications ? 'danger' : 'success',
        ]) ?>
    </a>
    <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="notificationMenuToggle">
        <div class="card border-0">
            <div class="card-header">
                <?= __('Notifications ({count} unread)', ['count' => $unreadNotificationCount]) ?>
            </div>
            <?php if ($notificationCount === 0): ?>
                <div class="card-body small text-muted bg-light">
                    <?= __('You have no notifications.') ?>
                </div>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($notifications as $notification): ?>
                        <?php
                        $class = null;
                        $link = $notification->renderLink($this, ['class' => ['card-link']]);

                        if ($notification->isMarkedAsRead()) {
                            $class = 'bg-light';
                        } else {
                            $link = $this->Html->tag('strong', $link);
                        }
                        ?>
                        <li class="list-group-item <?= $class ?>">
                            <?= $link ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php endif ?>
            <?= $this->Html->link(__('Show All'), $identity->getNotificationsRoute(),
                ['class' => ['card-link', 'py-2', 'small', 'text-center']]
            ) ?>
        </div>
    </div>
</div>

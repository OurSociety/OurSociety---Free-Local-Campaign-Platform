<?php
declare(strict_types=1);

namespace OurSociety\TestSuite\Behat\Page\Element\Layout;

use OurSociety\TestSuite\Behat\Page\Element\Element;

class NotificationMenu extends Element
{
    protected $selector = '#notificationMenu';

    public function getUnreadNotificationCount(): int
    {
        return (int)$this->findByCss('.badge')->getText();
    }
}

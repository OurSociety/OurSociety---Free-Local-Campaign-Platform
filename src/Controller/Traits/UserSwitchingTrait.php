<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

use Cake\Routing\Router;

trait UserSwitchingTrait
{
    /**
     * Is admin switching users?
     *
     * Detects if the request:
     *
     *  - matches the URL for the switch users action
     *  - session indicates an admin who is currently acting as another user
     *
     * @return bool True if request is an admin trying to switch users.
     */
    private function isAdminSwitchingUsers(): bool
    {
        if ($this->request->getUri()->getPath() !== Router::reverse(['_name' => 'admin:users:switch'])) {
            return false;
        }

        /** @var User|null $admin */
        $admin = $this->request->session()->read('Auth.Admin');

        if ($admin === null) {
            return false;
        }

        return $admin->isAdmin();
    }
}

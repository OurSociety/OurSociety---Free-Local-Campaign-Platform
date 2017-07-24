<?php
declare(strict_types=1);

namespace OurSociety\View\Cell\Navbar;

use Cake\View\Cell;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;

/**
 * User cell.
 */
class UserCell extends Cell
{
    /**
     * Default display.
     *
     * Displays the currently logged in user or, if logged in user is an admin, the ability to switch users.
     *
     * @return void
     */
    public function display(): void
    {
        /** @var User $user */
        $user = $this->request->session()->read('Auth.User');

        $this->set([
            'user' => $user,
            'users' => $this->getUsers($user),
        ]);
    }

    /**
     * Get users.
     *
     * Returns a list of users for the dropdown if the actual user in an admin.
     *
     * @param User $user The currently logged in user.
     * @return array|null The list of users, or null if not an admin.
     */
    protected function getUsers(User $user): ?array
    {
        $actualUser = $this->request->session()->read('Auth.Admin') ?: $user;

        if (!$actualUser->isAdmin()) {
            return null;
        }

        /** @var UsersTable $users */
        $users = $this->loadModel('Users');

        return $users->getListGroupedByRole()->toArray();
    }
}

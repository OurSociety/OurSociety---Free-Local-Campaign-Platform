<?php
declare(strict_types=1);

namespace OurSociety\Action\Admin\Users;

use Cake\Http\Response;
use OurSociety\Action\Action;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;

class ImpersonateUserAction extends Action
{
    const MESSAGE_IDENTITY_ASSUMED = 'You have assumed the identity of {name}.';

    const MESSAGE_IDENTITY_REVERTED = 'Your identity has been reverted back to {name}.';

    const SESSION_KEY_ADMIN = 'Admin';

    public function __invoke(...$params): ?Response
    {
        $slug = $this->getRequestData('user');

        if ($slug !== null) {
            $this->storeAdminInSession();
            $identity = $this->assumeIdentity($slug);
        } else {
            $identity = $this->revertIdentity();
            $this->deleteAdminFromSession();
        }

        return $this->redirect($identity->getDashboardRoute());
    }

    private function assumeIdentity(string $slug): User
    {
        /** @var User $user */
        $user = UsersTable::instance()->find('auth')->where(['slug' => $slug])->firstOrFail();
        $this->authenticateAs($user);
        $this->setWarningMessage(__(self::MESSAGE_IDENTITY_ASSUMED, ['name' => $user->name]));

        return $user;
    }

    private function revertIdentity(): User
    {
        /** @var User $admin */
        $admin = $this->readSession(self::SESSION_KEY_ADMIN);
        $this->authenticateAs($admin);
        $this->setInfoMessage(__(self::MESSAGE_IDENTITY_REVERTED, ['name' => $admin->name]));

        return $admin;
    }

    private function deleteAdminFromSession(): void
    {
        $this->deleteSession(self::SESSION_KEY_ADMIN);
    }

    private function storeAdminInSession(): void
    {
        $this->writeSession(self::SESSION_KEY_ADMIN, $this->getIdentity());
    }
}

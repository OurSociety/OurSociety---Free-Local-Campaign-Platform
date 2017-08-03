<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use OurSociety\Model\Entity\User;

trait AuthorizationTrait
{
    /**
     * {@inheritdoc}
     *
     * - Adds simple role-based permission checking.
     */
    public function isAuthorized(User $user, ?ServerRequest $request = null): bool
    {
        $user->seen();

        $request = $request ?: $this->request;

        if ($this->isAdminSwitchingUsers()) {
            return true;
        }

        switch ($user->role) {
            case User::ROLE_ADMIN:
                return true;
            case User::ROLE_CITIZEN:
                return in_array($request->getParam('prefix'), [false, 'citizen'], true);
            case User::ROLE_POLITICIAN:
                return in_array($request->getParam('prefix'), [false, 'citizen', 'politician', 'politician/profile'], true);
            default:
                return false;
        }
    }
}

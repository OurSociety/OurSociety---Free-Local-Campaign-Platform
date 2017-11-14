<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

use Cake\Http\Cookie\Cookie;
use OurSociety\Model\Entity\User;

trait RememberMeTrait
{
    protected function rememberMe(): void
    {
        if ($this->components()->has('Auth') === false) {
            return;
        }

        if ($this->getCurrentUser() !== null) {
            return;
        }

        if ((new Cookie(self::COOKIE_NAME_REMEMBER_ME))->read() === null) {
            return;
        }

        /** @var User $user */
        $user = $this->Auth->identify();

        if ($user === false) {
            $this->response = $this->response->withExpiredCookie(self::COOKIE_NAME_REMEMBER_ME);

            return;
        }

        $user->seen();

        $this->Auth->setUser($user); // TODO: Use controller method setIdentity after merge
    }
}

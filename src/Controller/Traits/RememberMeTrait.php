<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

trait RememberMeTrait
{
    protected function rememberMe(): void
    {
        if ($this->components()->has('Auth') === false) {
            return;
        }

        if ($this->Auth->user() !== null) {
            return;
        }

        if ($this->Cookie->read(self::COOKIE_NAME_REMEMBER_ME) === null) {
            return;
        }

        /** @var User $user */
        $user = $this->Auth->identify();

        if ($user === false) {
            $this->Cookie->delete(self::COOKIE_NAME_REMEMBER_ME);

            return;
        }

        $user->seen();

        $this->Auth->setUser($user);
    }
}

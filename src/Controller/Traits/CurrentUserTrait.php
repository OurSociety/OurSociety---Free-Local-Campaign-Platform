<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

trait CurrentUserTrait
{
    protected function setCurrentUser(): void
    {
        if ($this->components()->has('Auth')) {
            $this->set('currentUser', $this->Auth->user());
        }
    }
}

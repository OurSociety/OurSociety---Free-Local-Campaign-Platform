<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use OurSociety\Controller\Component\AuthComponent;
use OurSociety\Model\Entity\User;

/**
 * Current user trait.
 *
 * @property AuthComponent $Auth
 * @method ComponentRegistry components($components = null)
 * @method Controller set($name, $value = null)
 */
trait CurrentUserTrait
{
    public function getCurrentUser(): ?User
    {
        return $this->components()->has('Auth')
            ? $this->Auth->user()
            : null;
    }

    protected function setCurrentUser(): void
    {
        if ($this->components()->has('Auth')) {
            $this->set('currentUser', $this->Auth->user());
        }
    }
}

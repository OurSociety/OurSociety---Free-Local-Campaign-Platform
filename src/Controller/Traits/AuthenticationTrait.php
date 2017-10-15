<?php
declare(strict_types=1);

namespace OurSociety\Controller\Traits;

use Authentication\Controller\Component\AuthenticationComponent;
use Authentication\Identity;
use Cake\Http\Response;
use OurSociety\Controller\Component\AuthComponent;
use OurSociety\Middleware\AuthorizationMiddleware;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\ORM\TableRegistry;
use RuntimeException;

/**
 * Authentication trait.
 *
 * Controller-level abstraction for authentication component interactions.
 *
 * @property AuthenticationComponent $Authentication
 */
trait AuthenticationTrait
{
    public function getIdentity(bool $fromDatabase = null): User
    {
        /** @var Identity $identity */
        $identity = $this->Authentication->getIdentity();

        if ($identity === null) {
            throw new RuntimeException('No authentication identity could be found');
        }

        /** @var User $user */
        $user = $identity->getOriginalData();

        if ($fromDatabase === true) {
            $user = $this->findIdentity($user->id);
        }

        return $user;
    }

    public function refreshIdentity(): void
    {
        $this->Authentication->setIdentity($this->getIdentity(true));
    }

    public function hasIdentity(): bool
    {
        if ($this->components()->has('Authentication') === false) {
            return false;
        }

        return $this->Authentication->getIdentity() !== null;
    }

    public function authenticateIdentity(string $identifier): void
    {
        $this->Authentication->setIdentity($this->findIdentity($identifier));
    }

    protected function enableAuthentication(): void
    {
        $this->loadComponent(AuthenticationComponent::class);
    }

    protected function findIdentity(string $identifier): User
    {
        /** @var UsersTable $usersTable */
        $usersTable = TableRegistry::get('Users');

        return $usersTable->findById($identifier)->find('auth')->firstOrFail();
    }

    protected function setIdentityToView(): void
    {
        $this->set('identity', $this->hasIdentity() ? $this->getIdentity() : null);
    }

    protected function unauthorizedRedirect(): Response
    {
        $this->Flash->set(AuthComponent::ERROR_AUTH_UNAUTHORIZED, [
            'element' => 'error',
            'key' => 'flash',
            'params' => ['class' => 'error'],
        ]);

        return $this->redirect(AuthorizationMiddleware::UNAUTHORIZED_REDIRECT_URL);
    }
}

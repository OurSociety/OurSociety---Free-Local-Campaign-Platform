<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use OurSociety\Model\Entity\User;

/**
 * Application controller.
 *
 * Base class for all controllers in the application. Configures essentials such as authentication.
 *
 * @property Component\FlashComponent $Flash
 */
abstract class AppController extends Controller
{
    const COOKIE_NAME_REMEMBER_ME = 'remember_me';

    /**
     * {@inheritdoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Auth', ['className' => Component\AuthComponent::class]);
        $this->loadComponent('Cookie');
        $this->loadComponent('Flash', ['className' => Component\FlashComponent::class]);
        $this->loadComponent('RequestHandler');

        /*
         * Enable the following components for recommended CakePHP security settings.
         *
         * See: http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * {@inheritdoc}
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->rememberMe();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeRender(Event $event): ?Response
    {
        if ($this->components()->has('Auth')) {
            $this->set('currentUser', $this->Auth->user());
        }

        return parent::beforeRender($event);
    }

    /**
     * {@inheritdoc}
     *
     * - Adds simple role-based permission checking.
     */
    public function isAuthorized(User $user, ?ServerRequest $request = null): bool
    {
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

        return $admin->role === User::ROLE_ADMIN;
    }

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

    protected function refreshAuth(?User $user = null): void
    {
        $id = $user !== null ? $user->id : $this->Auth->user('id');
        $authUser = $this->loadModel('Users')->find('auth')->where(['Users.id' => $id])->firstOrFail();

        $this->Auth->setUser($authUser);
    }
}

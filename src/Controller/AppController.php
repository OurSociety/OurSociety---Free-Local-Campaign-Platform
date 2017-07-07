<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;

/**
 * Application controller.
 *
 * Base class for all controllers in the application. Configures essentials such as authentication.
 */
abstract class AppController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Auth', ['className' => Component\AuthComponent::class]);
        $this->loadComponent('Flash');
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
    public function beforeRender(Event $event): ?Response
    {
        if ($this->components()->has('Auth')) {
            $this->set('currentUser', $this->getUser());
        }

        return parent::beforeRender($event);
    }

    /**
     * TODO: Make Auth::user() return User?
     *
     * @param array|null $user
     * @return null|User
     */
    public function getUser(array $user = null): ?User
    {
        $user = $user ?: $this->Auth->user();

        if ($user === null) {
            return null;
        }

        return new User($user);
    }

    /**
     * {@inheritdoc}
     *
     * - Adds simple role-based permission checking.
     */
    public function isAuthorized(array $user = null, ServerRequest $request = null): bool
    {
        $request = $request ?: $this->request;

        switch ($this->getUser($user)->role) {
            case UsersTable::ROLE_ADMIN:
                return true;
            case UsersTable::ROLE_CITIZEN:
                return in_array($request->getParam('prefix'), [false, 'citizen'], true);
            case UsersTable::ROLE_POLITICIAN:
                return in_array($request->getParam('prefix'), [false, 'citizen', 'politician'], true);
            default:
                return false;
        }
    }
}

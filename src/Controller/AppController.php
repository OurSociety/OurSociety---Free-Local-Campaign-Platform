<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\RequestHandlerComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Gourmet\KnpMenu\Controller\Component\MenuComponent;
use OurSociety\Controller\Component\AuthComponent;
use OurSociety\Controller\Component\FlashComponent;
use Psr\Http\Message\ResponseInterface as Response;
use Search\Controller\Component\PrgComponent;

/**
 * Application controller.
 *
 * Base class for all controllers in the application. Configures essentials such as authentication.
 *
 * @property Component\AuthComponent $Auth
 * @property Component\FlashComponent $Flash
 */
abstract class AppController extends Controller
{
    const COOKIE_NAME_REMEMBER_ME = 'remember_me';

    use Traits\AuditLogTrait;
    use Traits\AuthorizationTrait;
    use Traits\ClassNameSupportTrait;
    use Traits\CurrentUserTrait;
    use Traits\RememberMeTrait;
    use Traits\SecurityTrait;
    use Traits\UserSwitchingTrait;

    /**
     * {@inheritdoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent(AuthComponent::class);
        $this->loadComponent(CookieComponent::class);
        $this->loadComponent(FlashComponent::class);
        $this->loadComponent(MenuComponent::class);
        $this->loadComponent(PrgComponent::class);
        $this->loadComponent(RequestHandlerComponent::class);

        $this->loadSecurityComponents();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->rememberMe();
        $this->setupAuditLog();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeRender(Event $event): ?Response
    {
        $this->setCurrentUser();

        return parent::beforeRender($event);
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\RequestHandlerComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Gourmet\KnpMenu\Controller\Component\MenuComponent;
use OurSociety\Controller\Component\FlashComponent;
use Psr\Http\Message\ResponseInterface as Response;
use Search\Controller\Component\PrgComponent;

/**
 * Application controller.
 *
 * Base class for all controllers in the application. Configures essentials such as authentication.
 *
 * @property Component\AuthComponent $Auth
 * @property AuthenticationComponent $Authentication
 * @property Component\FlashComponent $Flash
 */
abstract class AppController extends Controller
{
    const COOKIE_NAME_REMEMBER_ME = 'remember_me';

    use Traits\ActionAwareTrait;
    use Traits\AuditLogTrait;
    use Traits\ClassNameSupportTrait;
    use Traits\AuthenticationTrait;
    use Traits\RememberMeTrait;
    use Traits\SecurityTrait;

    /**
     * {@inheritdoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->enableAuthentication();
        //$this->enableSecurity();

        $this->loadComponent(CookieComponent::class);
        $this->loadComponent(FlashComponent::class);
        $this->loadComponent(MenuComponent::class);
        $this->loadComponent(PrgComponent::class);
        $this->loadComponent(RequestHandlerComponent::class);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        //$this->rememberMe();
        $this->setupAuditLog();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeRender(Event $event): ?Response
    {
        $this->setIdentityToView();

        return parent::beforeRender($event);
    }
}

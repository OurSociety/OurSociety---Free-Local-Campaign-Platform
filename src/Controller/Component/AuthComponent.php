<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Component;

use OurSociety\Auth as AppAuth;
use OurSociety\Controller\AppController;
use Cake\Controller\Component as Cake;

/**
 * Application auth component settings.
 */
class AuthComponent extends Cake\AuthComponent
{
    const ERROR_AUTH_UNAUTHENTICATED = 'You need to login to access that area.';
    const ERROR_AUTH_UNAUTHORIZED = 'You do not have access to this area.';

    public function initialize(array $config): void
    {
        $this->setConfig(array_merge([
            'authorize' => ['Controller'], // TODO: Move a11n logic.
            'authError' => $this->user()
                ? __(self::ERROR_AUTH_UNAUTHORIZED)
                : __(self::ERROR_AUTH_UNAUTHENTICATED),
            'authenticate' => [
                self::ALL => [
                    'finder' => 'auth',
                    'fields' => ['username' => 'email'],
                    //'scope' => ['verified IS NOT' => null], // TODO: verified IS NOT NULL AND created < week(?) ago
                ],
                AppAuth\CookieAuthenticate::class => [
                    'cookie' => ['name' => AppController::COOKIE_NAME_REMEMBER_ME,
                ]],
                AppAuth\FormAuthenticate::class,
            ],
            'flash' => ['key' => 'flash', 'element' => 'info'],
            'loginAction' => ['_name' => 'users:login'],
            'loginRedirect' => ['_name' => 'citizen:dashboard'],
            'unauthorizedRedirect' => false, //$this->request->referer(), // TODO: Redirect loop.
        ], $config));

        parent::initialize($config);
    }
}

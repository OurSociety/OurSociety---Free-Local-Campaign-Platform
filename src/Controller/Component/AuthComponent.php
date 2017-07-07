<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Component;

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
                ? __(self::ERROR_AUTH_UNAUTHENTICATED)
                : __(self::ERROR_AUTH_UNAUTHORIZED),
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth',
                    'fields' => ['username' => 'email'],
                    'scope' => ['Users.active' => 1],
                ],
            ],
            'flash' => ['key' => 'flash', 'element' => 'info'],
            'loginAction' => ['_name' => 'users:login'],
            'loginRedirect' => ['_name' => 'admin:dashboard'], // TODO: Fix redirect URL for non-admin users.
            'unauthorizedRedirect' => false,
        ], $config));

        parent::initialize($config);
    }
}

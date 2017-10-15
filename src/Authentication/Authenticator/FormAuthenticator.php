<?php
declare(strict_types=1);

namespace OurSociety\Authentication\Authenticator;

use Authentication\Authenticator\AuthenticatorInterface;
use Authentication\Authenticator\ResultInterface;
use Authentication\Identifier\IdentifierCollection;
use OurSociety\Authentication\Identifier\PasswordIdentifier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class FormAuthenticator implements AuthenticatorInterface
{
    protected $_authenticator;

    public function __construct()
    {
        $identifiers = new IdentifierCollection;
        $identifiers->load('Password', ['className' => PasswordIdentifier::class]);

        $this->_authenticator = new \Authentication\Authenticator\FormAuthenticator($identifiers, [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
            'loginUrl' => ['_name' => 'users:login'],
        ]);
    }

    public function authenticate(ServerRequestInterface $request, ResponseInterface $response): ResultInterface
    {
        return $this->_authenticator->authenticate($request, $response);
    }
}

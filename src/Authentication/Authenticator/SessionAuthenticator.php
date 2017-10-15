<?php
declare(strict_types=1);

namespace OurSociety\Authentication\Authenticator;

use Authentication\Authenticator as Authentication;
use Authentication\Identifier\IdentifierCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SessionAuthenticator implements Authentication\AuthenticatorInterface
{
    protected $_authenticator;

    public function __construct(IdentifierCollection $identifiers, array $config = [])
    {
        $this->_authenticator = new Authentication\SessionAuthenticator($identifiers);
    }

    public function authenticate(ServerRequestInterface $request, ResponseInterface $response): Authentication\ResultInterface
    {
        return $this->_authenticator->authenticate($request, $response);
    }
}

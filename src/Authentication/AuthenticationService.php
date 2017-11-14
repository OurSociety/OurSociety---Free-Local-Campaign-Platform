<?php
declare(strict_types=1);

namespace OurSociety\Authentication;

use Authentication\AuthenticationServiceInterface;
use Authentication\Authenticator\AuthenticatorInterface;
use Authentication\Authenticator\ResultInterface;
use Authentication\Authenticator\SessionAuthenticator;
use Authentication\Identifier\IdentifierInterface;
use Authentication\IdentityInterface;
use OurSociety\Authentication\Authenticator\CookieAuthenticator;
use OurSociety\Authentication\Authenticator\FormAuthenticator;
use OurSociety\Authentication\Identifier\PasswordIdentifier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Authentication Service.
 *
 * Handles different types of *authentication* supported by the application.
 *
 * @see SessionAuthenticator for how the logged in session is configured.
 * @see CookieAuthenticator for how the "Keep me logged in" cookie is configured.
 * @see FormAuthenticator for how the login form logic is configured.
 * @see PasswordIdentifier for how users are looked up from the login form.
 */
class AuthenticationService implements AuthenticationServiceInterface
{
    protected $_authenticationService;

    public function __construct()
    {
        $this->_authenticationService = new \Authentication\AuthenticationService();
        $this->_authenticationService->loadAuthenticator('Session', ['className' => SessionAuthenticator::class]);
        //$this->_authenticationService->loadAuthenticator('Cookie', ['className' => CookieAuthenticator::class]);
        $this->_authenticationService->loadAuthenticator('Form', ['className' => FormAuthenticator::class]);
        $this->_authenticationService->loadIdentifier('Password', ['className' => PasswordIdentifier::class]);
    }

    public function loadAuthenticator($name, array $config = null): AuthenticatorInterface
    {
        return $this->_authenticationService->loadAuthenticator($name, $config ?? []);
    }

    public function loadIdentifier($name, array $config = null): IdentifierInterface
    {
        return $this->_authenticationService->loadIdentifier($name, $config ?? []);
    }

    public function authenticate(ServerRequestInterface $request, ResponseInterface $response): ResultInterface
    {
        return $this->_authenticationService->authenticate($request, $response);
    }

    public function getIdentity(): ?IdentityInterface
    {
        return $this->_authenticationService->getIdentity();
    }

    public function clearIdentity(ServerRequestInterface $request, ResponseInterface $response): array
    {
        return $this->_authenticationService->clearIdentity($request, $response);
    }

    public function setIdentity(ServerRequestInterface $request, ResponseInterface $response, $identity): array
    {
        return $this->_authenticationService->setIdentity($request, $response, $identity);
    }

    public function getAuthenticationProvider(): ?AuthenticatorInterface
    {
        return $this->_authenticationService->getAuthenticationProvider();
    }

    public function getResult(): ?ResultInterface
    {
        return $this->_authenticationService->getResult();
    }
}

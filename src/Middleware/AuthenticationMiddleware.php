<?php
declare(strict_types=1);

namespace OurSociety\Middleware;

use Authentication\Authenticator\ResultInterface;
use Authentication\Identity;
use Authentication\Middleware as Authentication;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use OurSociety\Authentication\AuthenticationService;
use OurSociety\Controller\UsersController;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\TokensTable;
use OurSociety\ORM\TableRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Authentication Middleware.
 *
 * Handles *authentication* of users.
 *
 * @see AuthenticationService for configured authenticators.
 * @see UsersController for related actions.
 */
class AuthenticationMiddleware implements MiddlewareInterface
{
    protected $_middleware;

    public function __construct()
    {
        $this->_middleware = new Authentication\AuthenticationMiddleware(new AuthenticationService());
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ?ResponseInterface
    {
        if ($this->isLoginUrl($request) === true) {
            $request = $this->convertTokenCookieToPostRequest($request);
        }

        $response = ($this->_middleware)($request, $response, $next);

        $response = $this->writeTokenCookieToResponse($request, $response);

        return $response;
    }

    private function convertTokenCookieToPostRequest(ServerRequestInterface $request): ServerRequestInterface
    {
        return $request;
    }

    private function writeTokenCookieToResponse(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        /** @var ResultInterface $request */
        $result = $request->getAttribute('authenticationResult');

        if ($result === null) {
            return $response;
        }

        if ($result->getCode() !== ResultInterface::SUCCESS) {
            return $response;
        }

        $requestData = $request->getParsedBody();
        dd($requestData);


        /** @var Identity $identity */
        $identity = $request->getAttribute('identity');

        /** @var TokensTable $tokensTable */
        $tokensTable = TableRegistry::get('Tokens');

        /** @var User $user */
        $user = $identity->getOriginalData();

        $token = $tokensTable->createToken($user);

        /** @var Response $response */
        d($response);
        $response = $response->withCookie('token', [
            'value' => ['email' => $requestData['email'], 'password' => $requestData['password']],
            'expire' => FrozenTime::now()->addYear(),
            'path' => $request->getAttribute('webroot'),
            'domain' => '',
            'secure' => true,
            'httpOnly' => true,
        ]);
        dd($response);

        return $response;
    }

    private function isLoginUrl(ServerRequestInterface $request): bool
    {
        $requestPath = $request->getUri()->getPath();
        $logoutPath = Router::url(['_base' => false, '_name' => 'users:login']);

        return strcasecmp($requestPath, $logoutPath) === 0;
    }
}

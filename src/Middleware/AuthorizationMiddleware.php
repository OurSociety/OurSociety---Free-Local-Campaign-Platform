<?php
declare(strict_types=1);

namespace OurSociety\Middleware;

use Authentication\Identity;
use CakeDC\Auth\Rbac\Rbac;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Authorization Middleware.
 *
 * Handles authorization by delegating to CakeDC's RBAC logic.
 *
 * @see `config/permissions.php` for where those rules are configured.
 */
class AuthorizationMiddleware implements MiddlewareInterface
{
    public const UNAUTHORIZED_REDIRECT_URL = ['_name' => 'users:login'];

    protected $_middleware;

    public function __construct()
    {
        $rbac = new Rbac([
            'default_role' => 'guest',
        ]);

        $this->_middleware = new RbacMiddleware($rbac, [
            'unauthorizedBehavior' => RbacMiddleware::UNAUTHORIZED_BEHAVIOR_REDIRECT,
            'unauthorizedRedirect' => self::UNAUTHORIZED_REDIRECT_URL,
        ]);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ?ResponseInterface
    {
        //$request = $this->_setUserRoleKey($request);
        //
        return ($this->_middleware)($request, $response, $next);
    }

    /**
     * Copies user data from `Auth` to `Auth.User` key where Rbac class expects it.
     *
     * @param ServerRequestInterface $request
     * @return ServerRequestInterface
     */
    protected function _setUserRoleKey(ServerRequestInterface $request): ServerRequestInterface
    {
        $identity = $request->getAttribute('identity');
        if ($identity !== null) {
            /** @var User $user */
            $user = $identity->getOriginalData();
            $user->set('User', ['role' => $user->role]);

            $request = $request->withAttribute('identity', new Identity($user));
        }

        return $request;
    }
}

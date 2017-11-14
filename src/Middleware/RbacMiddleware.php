<?php
declare(strict_types=1);

namespace OurSociety\Middleware;

use Authentication\Identity;
use CakeDC\Auth\Middleware as CakeDC;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * RBAC Middleware.
 *
 * @see AuthorizationMiddleware This class is used internally by the authorization layer.
 * @see CakeDC\RbacMiddleware This class overrides the CakeDC version to fix user data path.
 */
class RbacMiddleware extends CakeDC\RbacMiddleware
{
    /**
     * {@inheritdoc}. Overrides parent method to properly pass user data to Rbac class.
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        /** @var Identity $identity */
        $identity = $request->getAttribute('identity');

        $userData = [];
        if ($identity !== null) {
            /** @var User|null $user */
            $user = $identity->getOriginalData();
            $userData = $user ? $user->toArray() : [];
        }

        if (!$this->rbac->checkPermissions($userData, $request)) {
            return $this->notAuthorized($userData, $request, $response);
        }

        return $next($request, $response);
    }
}

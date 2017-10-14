<?php
declare(strict_types=1);

namespace OurSociety\Middleware;

use Cake\Network\Session;
use OurSociety\Model\Table\UsersTable;
use OurSociety\ORM\TableRegistry;
use OurSociety\Shell\ScreenshotShell;
use OurSociety\Test\Fixture\UsersFixture;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Screenshot middleware
 */
class ScreenshotMiddleware
{

    /**
     * Invoke method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @param callable $next Callback to invoke the next middleware.
     * @return \Psr\Http\Message\ResponseInterface A response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $userAgent = $request->getHeader('User-Agent')[0];

        if (strpos($userAgent, ScreenshotShell::USER_AGENT) !== 0) {
            return $next($request, $response);
        }

        if (preg_match(sprintf('/%s \((.*)\)/', ScreenshotShell::USER_AGENT), $userAgent, $matches) !== 1) {
            return $next($request, $response);
        }

        $password = $matches[1];

        /** @var UsersTable $users */
        $users = TableRegistry::get('Users');
        $user = $users->find('auth')->where([
            'email' => UsersFixture::ADMIN_EMAIL,
            'password' => $password,
        ])->firstOrFail();

        /** @var Session $session */
        $session = $request->getAttribute('session');
        $session->write('Auth.User', $user);

        return $next($request, $response);
    }
}

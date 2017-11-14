<?php
declare(strict_types=1);

namespace OurSociety;

use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use OurSociety\Middleware\AuthenticationMiddleware;
use OurSociety\Middleware\AuthorizationMiddleware;
use OurSociety\Middleware\ScreenshotMiddleware;

/**
 * Application setup class.
 *
 * Defines bootstrapping logic and middleware layers in use by the application.
 *
 * @see ErrorHandlerMiddleware for error pages due to exceptions that bubble up.
 * @see AssetMiddleware for plugin/theme assets as documented by CakePHP.
 * @see RoutingMiddleware for routing of URLs (see `config/routes.php`)
 * @see ScreenshotMiddleware for how ScreenshotShell bypasses authentication.
 * @see AuthenticationMiddleware for user authentication throughout the application (e.g. *who* has access).
 * @see AuthorizationMiddleware for role-based access control (e.g. *what* can be accessed).
 */
class Application extends BaseApplication
{
    /**
     * Setup the middleware queue your application will use.
     *
     * @see \OurSociety\Auth\AuthenticationService
     * @param MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue
            ->add(ErrorHandlerMiddleware::class)
            ->add(AssetMiddleware::class)
            ->add(new RoutingMiddleware($this))
            ->add(ScreenshotMiddleware::class)
            ->add(AuthenticationMiddleware::class)
            ->add(AuthorizationMiddleware::class);
    }
}

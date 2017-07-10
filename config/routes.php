<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * Default route class used by scopes.
 *
 * Set to DashedRoute for `/urls/with-dashes/in-them`.
 */
Router::defaultRouteClass(DashedRoute::class);

/**
 * Default scope.
 */
Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home'], ['_name' => 'pages:home']);
    $routes->connect('/forgot', ['controller' => 'Users', 'action' => 'forgot'], ['_name' => 'users:forgot']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login'], ['_name' => 'users:login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout'], ['_name' => 'users:logout']);
    $routes->connect('/profile', ['controller' => 'Users', 'action' => 'profile'], ['_name' => 'users:profile']);
    $routes->connect('/register', ['controller' => 'Users', 'action' => 'register'], ['_name' => 'users:register']);
    $routes->connect('/reset', ['controller' => 'Users', 'action' => 'reset'], ['_name' => 'users:reset']);
    $routes->connect('/verify', ['controller' => 'Users', 'action' => 'verify'], ['_name' => 'users:verify']);
    $routes->connect('/*', ['controller' => 'Pages', 'action' => 'display']);
});

/**
 * Citizen prefixed routes.
 *
 * All routes here will have URLs prefixed with `/citizen` and names prefixed with `citizen:`.
 */
Router::prefix('citizen', ['_namePrefix' => 'citizen:'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index'], ['_name' => 'dashboard']);
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Politician prefixed routes.
 *
 * All routes here will have URLs prefixed with `/politician` and names prefixed with `politician:`.
 */
Router::prefix('politician', ['_namePrefix' => 'politician:'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index'], ['_name' => 'dashboard']);
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Admin prefixed routes.
 *
 * All routes here will have URLs prefixed with `/admin` and names prefixed with `admin:`.
 */
Router::prefix('admin', ['_namePrefix' => 'admin:'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index'], ['_name' => 'dashboard']);
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Plugin routes.
 *
 * Uncomment if you use `Plugin::load(..., ['routes' => true])` in `bootstrap.php`.
 */
//\Cake\Core\Plugin::routes();

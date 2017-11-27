<?php
declare(strict_types=1);

namespace OurSociety\Routing\Route;

use Cake\Routing\Route\RedirectRoute;
use Cake\Routing\Route\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * NamedRedirectRoute.
 *
 * Proxy class to enable pass-through support for named routes to core `RedirectRoute` class.
 */
class NamedRedirectRoute extends Route
{
    /**
     * @var RedirectRoute
     */
    private $redirectRoute;

    /**
     * {@inheritdoc}
     */
    public function __construct($template, $defaults = [], array $options = [])
    {
        parent::__construct($template, $defaults, $options);

        $this->redirectRoute = new RedirectRoute($template, $defaults, $options);
    }

    /**
     * Proxy method to `Route::match()`.
     */
    /** @noinspection SenselessProxyMethodInspection */
    public function match(array $url, array $context = [])
    {
        return parent::match($url, $context);
    }

    /**
     * Proxy method to `RedirectRoute::parseRequest()`.
     */
    public function parseRequest(ServerRequestInterface $request)
    {
        return $this->redirectRoute->parseRequest($request);
    }
}

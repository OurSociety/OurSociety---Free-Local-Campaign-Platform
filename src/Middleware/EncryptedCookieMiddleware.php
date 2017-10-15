<?php
declare(strict_types=1);

namespace OurSociety\Middleware;

use Cake\Utility\Security;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EncryptedCookieMiddleware implements MiddlewareInterface
{
    protected $_middleware;

    public function __construct()
    {
        $this->_middleware = new \Cake\Http\Middleware\EncryptedCookieMiddleware(['remember_me'], Security::getSalt());
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        return ($this->_middleware)($request, $response, $next);
    }
}

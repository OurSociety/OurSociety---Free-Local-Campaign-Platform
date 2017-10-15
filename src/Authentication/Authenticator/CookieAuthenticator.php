<?php
declare(strict_types=1);

namespace OurSociety\Authentication\Authenticator;

use Authentication\Authenticator\AbstractAuthenticator;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Routing\Router;
use OurSociety\Controller\UsersController;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CookieAuthenticator extends AbstractAuthenticator
{
    /**
     * Authenticate.
     *
     * @param ServerRequestInterface|ServerRequest $request
     * @param ResponseInterface|Response $response
     * @return ResultInterface
     */
    public function authenticate(ServerRequestInterface $request, ResponseInterface $response): ResultInterface
    {
        if ($this->isLogoutPage($request) === true) {
            $this->deleteCookie();

            return new Result(null, Result::FAILURE_OTHER, ['Deleted token cookie upon signing user out']);
        }

        if ($this->isLoginPage($request) === true) {
            $this->createCookie();

            return new Result(null, Result::FAILURE_OTHER, ['Created token cookie upon signing user in']);
        }


        $fields = $this->_config['fields'];
        if (!$this->_checkCookie($request, $fields)) {
            return new Result(null, Result::FAILURE_CREDENTIALS_NOT_FOUND, [
                'Login cookie not found',
            ]);
        }

        $cookie = $this->_getCookie($request);
        $user = $this->_getUser($cookie);

        if (empty($user)) {
            return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND, $this->identifiers()->getErrors());
        }

        $flashKey = 'Flash.flash';
        $session = $request->getSession();
        $messages = $session->read($flashKey);
        $messages[] = [
            'message' => __(UsersController::MESSAGE_REMEMBER_ME_SUCCESS, ['name' => $user->name]),
            'key' => 'flash',
            'element' => 'flash',
            'params' => [
                'class' => [
                    'alert',
                    'alert-dismissible',
                    'fade',
                    'in',
                    'alert',
                    'alert-dismissible',
                    'fade',
                    'show',
                    'alert-info',
                ],
                'attributes' => ['role' => 'alert'],
                'element' => 'flash',
                'className' => 'OurSociety\View\Helper\FlashHelper',
            ],
        ];
        $session->write($flashKey, $messages);

        return new Result($user, Result::SUCCESS);
    }

    protected function _checkCookie(ServerRequestInterface $request, array $fields)
    {
        dd('hi');
        /** @var ServerRequest $cookie */
        $cookie = $this->_getCookie($request);

        if ($cookie === null) {
            return false;
        }

        foreach ([$fields['username'], $fields['password']] as $field) {
            if (!isset($cookie[$field])) {
                return false;
            }

            $value = $cookie[$field];
            if (empty($value) || !is_string($value)) {
                return false;
            }
        }

        return true;
    }

    protected function _getCookie(ServerRequestInterface $request): ?array
    {
        //dd($request->getCookieParams()['remember_me'] ?? null);

        return $request->getCookieParams()['remember_me'] ?? null;
    }

    protected function _getUser($cookie): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->identifiers()->identify($cookie);
    }

    protected function isLoginPage(ServerRequestInterface $request): bool
    {
        return $this->isCurrentUrl($request, ['_name' => 'users:login']);
    }

    protected function isLogoutPage(ServerRequestInterface $request): bool
    {
        return $this->isCurrentUrl($request, ['_name' => 'users:logout']);
    }

    protected function isCurrentUrl(ServerRequestInterface $request, array $url): bool
    {
        $requestPath = $request->getUri()->getPath();
        $logoutPath = Router::url(['_base' => false] + $url);

        return strcasecmp($requestPath, $logoutPath) === 0;
    }
}

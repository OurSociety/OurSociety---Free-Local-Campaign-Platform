<?php
declare(strict_types=1);

namespace OurSociety\Action\Users;

use Cake\Http\Cookie\Cookie;
use Cake\Http\Response;
use OurSociety\Action\Action;
use OurSociety\Model\Entity\Token;
use OurSociety\Model\Table\TokensTable;

class LoginAction extends Action
{
    public const MESSAGE_LOGIN_ERROR = 'Sorry, that email and password combination was not recognized.';

    public const MESSAGE_LOGIN_SUCCESS = 'Welcome to OurSociety!';

    public const MESSAGE_REMEMBER_ME_SUCCESS = 'Welcome back, {name}!';

    /**
     * @route GET /sign-in
     * @routeName users:login
     */
    public function __invoke(...$params): ?Response
    {
        if ($this->hasIdentity()) {
            $user = $this->getIdentity();
            $user->seen();

            if ($this->isKeepMeLoggedInChecked() === true) {
                $this->setTokenCookie();
            }

            $message = __(self::MESSAGE_LOGIN_SUCCESS);
            if ($user->get('from_cookie') === true) {
                $message = __(self::MESSAGE_REMEMBER_ME_SUCCESS, ['name' => $user->name]);
            }

            $this->setSuccessMessage($message);

            return $this->redirect($user->getDashboardRoute());
        }

        $this->setBootstrapContainerToFluid();

        if ($this->isPostRequest() === true) {
            $this->setErrorMessage(__(self::MESSAGE_LOGIN_ERROR));
        }

        return null;
    }

    private function setTokenCookie(): void
    {
        $this->setCookie($this->createTokenCookie());
    }

    private function createTokenCookie(): Cookie
    {
        $token = $this->createToken();

        return (new Cookie('token'))
            ->withValue($token->cookie_value)
            ->withExpiry($token->expires);
    }

    private function isKeepMeLoggedInChecked(): bool
    {
        return (bool)$this->getRequestData('remember_me', false);
    }

    private function createToken(): Token
    {
        return TokensTable::instance()->createToken($this->getIdentity());
    }
}

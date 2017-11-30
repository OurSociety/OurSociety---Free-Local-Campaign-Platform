<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Mailer\MailerAwareTrait;
use Crud\Action\EditAction;
use Crud\Action\ViewAction;
use CrudUsers\Action\ForgotPasswordAction;
use CrudUsers\Action\LogoutAction;
use CrudUsers\Action\ResetPasswordAction;
use CrudUsers\Action\VerifyAction;
use OurSociety\Controller\Action\LoginAction;
use OurSociety\Controller\Action\RegisterAction;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property UsersTable $Users
 */
class UsersController extends AppController
{
    use MailerAwareTrait;

    const MESSAGE_FORGOT_ERROR = 'Sorry, an account with that email address could not be found.';

    const MESSAGE_FORGOT_SUCCESS = 'Please check your email for recovery instructions.';

    //const MESSAGE_LOGIN_ERROR = 'Sorry, that email and password combination was not recognized.';
    //
    //const MESSAGE_LOGIN_SUCCESS = 'Welcome to OurSociety!';
    //
    //const MESSAGE_REMEMBER_ME_SUCCESS = 'Welcome back, {name}!';

    const MESSAGE_LOGOUT_SUCCESS = 'You have been signed out.';

    const MESSAGE_RESET_ERROR = 'Could not update the account';

    const MESSAGE_RESET_SUCCESS = 'Password updated successfully';

    /**
     * {@inheritdoc}
     *
     * - Map actions to CrudUsers plugin.
     * - Allow public access to register page.
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Crud', [
            'actions' => [
                //'index' => Action\IndexAction::class,
                //'add' => Action\AddAction::class,
                //'edit' => Action\EditAction::class,
                //'view' => Action\ViewAction::class,
                //'delete' => Action\DeleteAction::class,
                //'export' => Action\ExportAction::class,
                //'lookup' => LookupAction::class,
            ],
            'listeners' => [
                //ViewListener::class, // All CrudView configuration inside this class.
                //ViewSearchListener::class,
                //SearchListener::class,
                //RedirectListener::class,
                //RelatedModelsListener::class,
            ],
        ]);

        if ($this->Crud === false) {
            return;
        }

        collection([
            'forgot' => ForgotPasswordAction::class,
            'login' => LoginAction::class,
            'logout' => LogoutAction::class,
            'onboarding' => EditAction::class,
            'profile' => ViewAction::class,
            'register' => RegisterAction::class,
            'reset' => ResetPasswordAction::class,
            'verify' => VerifyAction::class,
        ])->each(function (string $actionClass, string $actionName) {
            $this->Crud->mapAction($actionName, $actionClass);
        });
    }

    /**
     * @route GET /edit
     * @routeName users:edit
     */
    public function edit(string $slug = null): ?Response
    {
        if ($this->hasIdentity() === false) {
            return $this->unauthorizedRedirect();
        }

        if ($slug === null) {
            $slug = $this->getIdentity()->slug;
            $this->request->addParams(['pass' => [$slug]]);
        }

        return $this->Crud->execute();
    }

    /**
     * @route GET /forgot
     * @routeName users:forgot
     */
    public function forgot(): ?Response
    {
        $this->config('messages.success.text', __(self::MESSAGE_FORGOT_SUCCESS));
        $this->config('messages.error.text', __(self::MESSAGE_FORGOT_ERROR));

        $this->Crud->on('afterForgotPassword', function (Event $event) {
            if ($event->getSubject()->success !== true) {
                return;
            }

            /** @var User $user */
            $user = $event->getSubject()->entity;
            $user = $this->Users->saveOrFail($user->withToken());

            $this->getMailer('User')->send('forgot', [$user]);

            $this->config('redirectUrl', ['_name' => 'users:reset', '?' => ['email' => $user->email]]);
        });

        return $this->Crud->execute();
    }

    /**
     * @route GET /sign-out
     * @routeName users:logout
     */
    public function logout(): ?Response
    {
        $this->deleteRememberMeCookie();
        $this->Authentication->logout();
        $this->Flash->info(__(self::MESSAGE_LOGOUT_SUCCESS));

        return $this->redirect(['_name' => 'users:login']);
    }

    /**
     * @route GET /profile
     * @routeName users:profile
     */
    public function profile(): ?Response
    {
        if ($this->hasIdentity() === false) {
            return $this->unauthorizedRedirect();
        }

        $this->Crud->on('beforeFind', function (Event $event) {
            $event->subject->query = $event->subject->repository->find()->where(['id' => $this->getIdentity()->id]);
        });

        return $this->Crud->execute();
    }

    /**
     * @route GET /join-oursociety
     * @routeName users:register
     */
    public function register(): ?Response
    {
        $this->Crud->on('beforeRender', function (Event $event) {
            if ($this->hasIdentity()) {
                return $this->redirect($this->getIdentity()->getDashboardRoute());
            }
        });

        $this->Crud->on('afterRegister', function (Event $event) {
            if ($event->getSubject()->success === true) {
                /** @var User $user */
                $user = $event->getSubject()->entity;
                $this->authenticateIdentity($user->id);
                $this->config('redirectUrl', ['_name' => 'citizen:dashboard']);
            }
        });

        $this->set(['containerClass' => 'container-fluid']);

        return $this->Crud->execute();
    }

    /**
     * @route GET /reset-password
     * @routeName users:reset
     */
    public function reset(): ?Response
    {
        $this->config('messages.success.text', __(self::MESSAGE_RESET_SUCCESS));
        $this->config('messages.error.text', __(self::MESSAGE_RESET_ERROR));
        $this->config('tokenField', 'token');

        $this->Crud->on('verifyToken', [$this, '_verifyToken']);

        $this->Crud->on('afterResetPassword', function (Event $event) {
            if ($event->getSubject()->success === false) {
                return;
            }

            $this->config('redirectUrl', [
                '_name' => 'users:login',
                '?' => ['email' => $event->getSubject()->entity->email],
            ]);
        });

        return $this->Crud->execute();
    }

    public function _verifyToken(Event $event): void
    {
        $subject = $event->getSubject();

        /** @var User|null $user */
        $user = $subject->entity;

        if ($user !== null && $user->token_expires !== null && $user->token_expires->gte(Time::now())) {
            $subject->set(['verified' => !$user->isTokenExpired()]);
        }
    }

    /**
     * @route GET /verify
     * @routeName users:verify
     */
    public function verify(): ?Response
    {
        $this->config('messages.success.text', __(self::MESSAGE_LOGIN_SUCCESS));
        $this->config('messages.error.text', __(self::MESSAGE_LOGIN_ERROR));

        $this->Crud->on('verifyToken', [$this, '_verifyToken']);

        return $this->Crud->execute();
    }

    /**
     * @route GET /onboarding
     * @routeName users:onboarding
     */
    public function onboarding(): ?Response
    {
        if ($this->hasIdentity() === false) {
            return $this->unauthorizedRedirect();
        }

        $this->set(['containerClass' => 'container-fluid']);

        $this->Crud->action()->setConfig('messages.success.text', 'Your location has been stored.');

        $this->Crud->on('beforeFind', function (Event $event) {
            $event->getSubject()->query = $this->Users->find()->where(['Users.id' => $this->getIdentity()->id]);
        });

        $this->Crud->on('beforeRedirect', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->refreshIdentity();
                $event->getSubject()->url = ['_name' => 'citizen:dashboard'];
            }
        });

        return $this->Crud->execute();
    }

    // TODO: Move this to CrudController, or move action configuration to new custom child actions.
    private function config($key, $value = null, $merge = null)
    {
        return $this->Crud->action()->setConfig($key, $value, $merge ?? true);
    }

    //private function createRememberMeCookie(): void
    //{
    //    $isKeepMeLoggedInChecked = (bool)$this->request->getData('remember_me');
    //
    //    if ($isKeepMeLoggedInChecked === false) {
    //        return;
    //    }
    //
    //    //$cookie = new AuthenticationTokenCookie($this->getIdentity());
    //
    //    /** @var TokensTable $tokensTable */
    //    $tokensTable = TableRegistry::get('Tokens');
    //    $token = $tokensTable->createToken($this->getIdentity());
    //
    //    $cookie = (new Cookie('token'))
    //        ->withValue($token->cookie_value)
    //        ->withExpiry($token->expires);
    //
    //    $this->response = $this->response->withCookie($cookie);
    //
    //    //$this->Cookie->write(self::COOKIE_NAME_REMEMBER_ME, [
    //    //    'email' => $this->request->getData('email'),
    //    //    'password' => $this->request->getData('password'),
    //    //]);
    //
    //    //if ((bool)$this->request->getData(self::COOKIE_NAME_REMEMBER_ME) === false) {
    //    //    return;
    //    //}
    //    //
    //    //$this->Cookie->configKey(self::COOKIE_NAME_REMEMBER_ME, [
    //    //    'expires' => '+1 year',
    //    //    'httpOnly' => true,
    //    //    'secure' => true,
    //    //    'encryption' => false, // The EncryptedCookieMiddleware handles this.
    //    //]);
    //    //
    //    //$this->Cookie->write(self::COOKIE_NAME_REMEMBER_ME, [
    //    //    'email' => $this->request->getData('email'),
    //    //    'password' => $this->request->getData('password'),
    //    //]);
    //}

    private function deleteRememberMeCookie(): void
    {
        if ($this->Cookie->check(self::COOKIE_NAME_REMEMBER_ME)) {
            $this->Cookie->delete(self::COOKIE_NAME_REMEMBER_ME);
        }
    }
}

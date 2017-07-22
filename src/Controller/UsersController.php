<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Mailer\MailerAwareTrait;
use Crud\Action as Crud;
use CrudUsers\Action as CrudUsers;
use OurSociety\Controller\Action;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property UsersTable $Users
 */
class UsersController extends CrudController
{
    use MailerAwareTrait;

    const MESSAGE_FORGOT_SUCCESS = 'Please check your email for recovery instructions.';
    const MESSAGE_FORGOT_ERROR = 'Sorry, an account with that email address could not be found.';
    const MESSAGE_LOGIN_SUCCESS = 'Welcome to OurSociety!';
    const MESSAGE_LOGIN_ERROR = 'Sorry, that email and password combination was not recognized.';
    const MESSAGE_LOGOUT_SUCCESS = 'You have been logged out.';
    const MESSAGE_RESET_SUCCESS = 'Password updated successfully';
    const MESSAGE_RESET_ERROR = 'Could not update the account';

    /**
     * {@inheritdoc}
     *
     * - Map actions to CrudUsers plugin.
     * - Allow public access to register page.
     */
    public function initialize(): void
    {
        parent::initialize();

        collection([
            'forgot' => CrudUsers\ForgotPasswordAction::class,
            'login' => Action\LoginAction::class,
            'logout' => CrudUsers\LogoutAction::class,
            'onboarding' => Crud\EditAction::class,
            'profile' => Crud\ViewAction::class,
            'register' => Action\RegisterAction::class,
            'reset' => CrudUsers\ResetPasswordAction::class,
            'verify' => CrudUsers\VerifyAction::class,
        ])->each(function (string $actionClass, string $actionName) {
            $this->Crud->mapAction($actionName, $actionClass);
        });

        $this->Auth->allow(['forgot', 'login', 'logout', 'register', 'reset', 'verify']);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeFilter(Event $event): ?Response
    {
        $this->config('scaffold.sidebar_navigation', false);

        return parent::beforeFilter($event);
    }

    /**
     * @route GET /edit
     * @routeName users:edit
     */
    public function edit(): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            $event->getSubject()->query = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')]);
        });

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
     * @route GET /login
     * @routeName users:login
     */
    public function login(): ?Response
    {
        $this->config('messages.success.text', __(self::MESSAGE_LOGIN_SUCCESS));
        $this->config('messages.error.text', __(self::MESSAGE_LOGIN_ERROR));

        $this->Crud->on('afterLogin', function (Event $event) {
            if ($event->getSubject()->success === true) {
                /** @var User $user */
                $user = $event->getSubject()->user;

                // Last seen time
                $user->seen();

                // Set redirect URL to correct dashboard
                $this->Auth->setConfig('loginRedirect', ['_name' => sprintf('%s:dashboard', $user->role)]);

                // Remember me cookie
                if ((bool)$this->request->getData('remember_me') === true) {
                    $this->Cookie->configKey('remember', [
                        'expires' => '+1 year',
                        'httpOnly' => true
                    ]);
                    $this->Cookie->write('remember', [
                        'email' => $this->request->getData('email'),
                        'password' => $this->request->getData('password')
                    ]);
                }
            }
        });

        return $this->Crud->execute();
    }

    /**
     * @route GET /logout
     * @routeName users:logout
     */
    public function logout(): ?Response
    {
        $this->config('messages.success.text', __(self::MESSAGE_LOGOUT_SUCCESS));

        return $this->Crud->execute();
    }

    /**
     * @route GET /profile
     * @routeName users:profile
     */
    public function profile(): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            $event->subject->query = $event->subject->repository->find()->where(['id' => $this->Auth->user('id')]);
        });

        return $this->Crud->execute();
    }

    /**
     * @route GET /register
     * @routeName users:register
     */
    public function register(): ?Response
    {
        $this->Crud->on('afterRegister', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->refreshAuth($event->getSubject()->entity);
                $this->config('redirectUrl', ['_name' => 'citizen:dashboard']);
            }
        });

        return $this->Crud->execute();
    }

    /**
     * @route GET /reset
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
        $this->Crud->action()->setConfig('messages.success.text', 'Thanks!');

        $this->Crud->on('beforeFind', function (Event $event) {
            $event->getSubject()->query = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')]);
        });

        $this->Crud->on('beforeRedirect', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->refreshAuth();
                $event->getSubject()->url = ['_name' => 'citizen:dashboard'];
            }
        });

        return $this->Crud->execute();
    }

    // TODO: Move this to CrudController, or move action configuration to new custom child actions.
    private function config($key, $value = null, $merge = true)
    {
        return $this->Crud->action()->setConfig($key, $value, $merge);
    }
}

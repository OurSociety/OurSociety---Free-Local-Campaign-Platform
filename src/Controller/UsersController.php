<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\Http\Response;
use Crud\Action as Crud;
use CrudUsers\Action as CrudUsers;

class UsersController extends CrudController
{
    const MESSAGE_FORGOT_SUCCESS = 'Please check your email for a recovery link.';
    const MESSAGE_LOGIN_SUCCESS = 'Welcome to OurSociety!';
    const MESSAGE_LOGIN_ERROR = 'Sorry, that email and password combination was not recognized.';
    const MESSAGE_LOGOUT_SUCCESS = 'You have been logged out.';

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
            'login' => CrudUsers\LoginAction::class,
            'logout' => CrudUsers\LogoutAction::class,
            'profile' => Crud\ViewAction::class,
            'register' => CrudUsers\RegisterAction::class,
            'reset' => CrudUsers\ResetPasswordAction::class,
            'verify' => CrudUsers\VerifyAction::class,
        ])->each(function (string $actionClass, string $actionName) {
            $this->Crud->mapAction($actionName, $actionClass);
        });

        $this->Auth->allow(['forgot', 'login', 'register', 'reset', 'verify']);
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
     * @route GET /forgot
     * @routeName users:forgot
     */
    public function forgot(): ?Response
    {
        $this->config('messages.success.text', __(self::MESSAGE_FORGOT_SUCCESS));

        $this->Crud->on('afterForgotPassword', function (Event $event) {
            if ($event->getSubject()->success === true) {
                // TODO: Send email.
            }
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
                $redirectRouteName = sprintf('%s:dashboard', $event->getSubject()->user['role']);
                $this->Auth->setConfig('loginRedirect', ['_name' => $redirectRouteName]);
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

    // TODO: Move this to CrudController, or move action configuration to new custom child actions.
    private function config($key, $value = null, $merge = true)
    {
        return $this->Crud->action()->setConfig($key, $value, $merge);
    }
}

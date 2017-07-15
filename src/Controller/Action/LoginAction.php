<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Action;

use Crud\Event\Subject;
use CrudUsers\Action as CrudUsers;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends CrudUsers\LoginAction
{
    /**
     * {@inheritdoc}. Redirects if logged in user tries accessing login page
     */
    protected function _get(): ?Response
    {
        parent::_get();

        $user = $this->_controller()->Auth->user();

        return $user ? $this->_successEntity($this->_subject(), $user) : null;
    }

    /**
     * {@inheritdoc}. Overrides parent with one difference, we call `_successEntity` instead of `_success`.
     */
    protected function _post(): ?Response
    {
        $subject = $this->_subject();

        $this->_trigger('beforeLogin', $subject);

        /** @var User $user */
        if ($user = $this->_controller()->Auth->identify()) {
            return $this->_successEntity($subject, $user);
        }

        $this->_error($subject);

        return null;
    }

    /**
     * {@inheritdoc}. Copy of `parent::_success` with one difference, type hint for `$user` is `User` instead of `array`.
     */
    protected function _successEntity(Subject $subject, User $user): Response
    {
        $subject->set(['success' => true, 'user' => $user]);

        $this->_trigger('afterLogin', $subject);
        /** @noinspection PhpUndefinedFieldInspection */
        $this->_controller()->Auth->setUser($subject->user);
        $this->setFlash('success', $subject);

        return $this->_redirect(
            $subject,
            $this->_controller()->Auth->redirectUrl()
        );
    }
}

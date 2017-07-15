<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Action;

use Crud\Event\Subject;
use CrudUsers\Action as CrudUsers;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends CrudUsers\RegisterAction
{
    /**
     * {@inheritdoc}
     *
     * TODO: Drop when we can redirect to '/' again.
     */
    protected function _success(Subject $subject): Response
    {
        $subject->set(['success' => true, 'created' => true]);

        $this->_trigger('afterRegister', $subject);
        $this->setFlash('success', $subject);

        $redirectUrl = $this->getConfig('redirectUrl') ?: '/';

        return $this->_redirect($subject, $redirectUrl);
    }
}

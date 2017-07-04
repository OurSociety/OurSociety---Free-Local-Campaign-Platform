<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Action;

use CrudUsers\Action as CrudUsers;
use Psr\Http\Message\ResponseInterface;

class LoginAction extends CrudUsers\LoginAction
{
    /**
     * {@inheritdoc}. Redirects if logged in user tries accessing login page
     */
    protected function _get(): ?ResponseInterface
    {
        parent::_get();

        $user = $this->_controller()->Auth->user();

        return $user
            ? $this->_success($this->_subject(), $user)
            : null;
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Crud\Action\BaseAction;
use OurSociety\Controller\AppController;

abstract class Action extends BaseAction
{
    protected function _controller(): AppController
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->_controller;
    }
}

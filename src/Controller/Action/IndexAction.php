<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Cake\Controller\Controller;
use Crud\Action as Crud;

class IndexAction extends Crud\IndexAction
{
    public function __construct(Controller $Controller, $config = [])
    {
        parent::__construct($Controller, $config);

        $this->setConfig('scaffold.actions_blacklist', ['dashboard']);
    }
}

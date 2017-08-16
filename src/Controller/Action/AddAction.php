<?php
declare(strict_types=1);

namespace OurSociety\Controller\Action;

use Cake\Controller\Controller;
use Crud\Action as Crud;

class AddAction extends Crud\AddAction
{
    public function __construct(Controller $Controller, $config = [])
    {
        parent::__construct($Controller, $config);

        $this->setConfig('scaffold.fields_blacklist', ['created', 'modified']);
    }
}

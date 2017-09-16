<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\CrudController;

class StatesController extends CrudController
{
    public function index(): ?Response
    {
        //$this->Crud->action()->setConfig('scaffold.fields', [
        //    'name' => ['help' => ''],
        //    'email',
        //    'created',
        //    'modified',
        //    'verified',
        //]);

        return $this->Crud->execute();
    }
}

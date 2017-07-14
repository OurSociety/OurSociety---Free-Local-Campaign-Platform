<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\CrudController;

class UsersController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'created', 'modified', 'active']);

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'active']);

        return $this->Crud->execute();
    }

    public function edit(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['id', 'name', 'email', 'active']);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'active', 'created', 'modified']);

        return $this->Crud->execute();
    }
}

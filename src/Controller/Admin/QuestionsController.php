<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

class QuestionsController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['category_id', 'question', 'type', 'created']);

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        return $this->Crud->execute();
    }

    public function edit(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields_blacklist', ['created']);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }
}

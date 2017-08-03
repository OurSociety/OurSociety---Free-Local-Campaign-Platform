<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

class AnswersController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'user_id' => ['title' => 'User'],
                    'question_id',
                    'name' => ['title' => 'Answer'],
                    'importance',
                    'created' => ['title' => 'When'],
                ],
                'breadcrumbs' => [new Breadcrumb('Answers')],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        return $this->_form();
    }

    public function edit(): ?Response
    {
        return $this->_form();
    }

    public function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'user_id' => ['title' => 'User'],
                    'question_id',
                    'answer' => ['type' => 'answer'],
                    'importance' => ['type' => 'importance'],
                    'created' => ['title' => 'When'],
                ],
                'breadcrumbs' => [new Breadcrumb('Answers')],
            ],
        ]);

        return $this->Crud->execute();
    }
}

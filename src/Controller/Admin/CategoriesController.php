<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

class CategoriesController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name',
                    'question_count' => ['title' => '# Questions'],
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name',
                    'question_count' => ['title' => '# Questions'],
                    'created',
                    'modified',
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function edit(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => ['name'],
            ],
        ]);

        return $this->Crud->execute();
    }
}

<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

class AspectsUsersController extends CrudController
{
    public function beforeFilter(Event $event): void
    {
        $this->modelClass = 'CategoriesUsers';

        parent::beforeFilter($event);
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'user_id',
                    'category_id',
                    'answer_count' => ['title' => '# Answers'],
                    'modified' => ['title' => 'Last Answer'],
                ],
                'actions' => ['index', 'view']
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }
}

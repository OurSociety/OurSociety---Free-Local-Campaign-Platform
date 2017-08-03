<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

class AspectsController extends CrudController
{
    public function beforeFilter(Event $event): void
    {
        $this->Crud->mapAction('dashboard', ['className' => DashboardAction::class]);
        $this->modelClass = 'Categories';

        parent::beforeFilter($event);
    }

    public function dashboard(): ?Response
    {
        $this->Crud->removeListener('ourSociety\view\listener\viewListener');
        return $this->Crud->execute();
    }

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

    public function add(): ?Response
    {
        return $this->_form();
    }

    public function edit(): ?Response
    {
        return $this->_form();
    }

    protected function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => ['name'],
            ],
        ]);

        return $this->Crud->execute();
    }
}

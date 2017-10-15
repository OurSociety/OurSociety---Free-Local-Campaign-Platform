<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\AppController;
use OurSociety\Model\Entity\Question;
use Psr\Http\Message\ResponseInterface as Response;

class QuestionsController extends AppController
{
    //public function beforeFilter(Event $event): void
    //{
    //    $this->Crud->mapAction('dashboard', DashboardAction::class);
    //
    //    parent::beforeFilter($event);
    //}

    //public function index(): ?Response
    //{
    //    $this->Crud->addListener('CrudView.ViewSearch', ['enabled' => true]);
    //    $this->Crud->action()->setConfig('scaffold.fields', ['category_id', 'question', 'type', 'level', 'created', 'modified']);
    //
    //    return $this->Crud->execute();
    //}

    public function add(): ?Response
    {
        return $this->form();
    }

    public function edit(): ?Response
    {
        return $this->form();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }

    public function form(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', [
            'id',
            'question' => ['type' => 'editor'],
            'level',
            'type' => ['type' => 'select', 'options' => Question::TYPES],
        ]);

        return $this->Crud->execute();
    }
}

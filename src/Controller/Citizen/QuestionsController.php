<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use Cake\Event\Event;
use OurSociety\Controller\Action\AnswerAction;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Table\QuestionsTable;

class QuestionsController extends CrudController
{
    public function beforeFilter(Event $event): void
    {
        parent::beforeFilter($event);

        $this->Crud->mapAction('index', [
            'className' => AnswerAction::class,
            'redirectUrl' => ['_name' => 'citizen:dashboard'],
        ]);

        $this->Crud->disable(['view', 'add', 'edit', 'delete']);

        $this->paginate = ['limit' => QuestionsTable::LIMIT_BATCH];
    }
}

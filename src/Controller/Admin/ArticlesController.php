<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Controller\CrudController;
use OurSociety\Controller\Traits\ActionAwareTrait;
use OurSociety\Listener\ViewListener;
use Psr\Http\Message\ResponseInterface as Response;

class ArticlesController extends CrudController
{
    use ActionAwareTrait;

    public function beforeFilter(Event $event): void
    {
        $this->Crud->mapAction('dashboard', ['className' => DashboardAction::class]);

        parent::beforeFilter($event);
    }

    public function dashboard(): ?Response
    {
        $this->Crud->removeListener(ViewListener::class);

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
                    'politician_id',
                    'slug',
                    'name' => ['label' => 'Title'],
                    'body' => ['type' => 'editor'],
                    'published' => ['type' => 'checkbox', 'help' => 'Politicians can publish.'],
                    'approved' => ['type' => 'checkbox', 'help' => 'Only admins can approve.'],
                ],
                'breadcrumbs' => [new Breadcrumb('Answers')],
            ],
        ]);

        return $this->Crud->execute();
    }
}

<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Controller\CrudController;
use OurSociety\Listener\ViewListener;
use Psr\Http\Message\ResponseInterface as Response;

class ArticlesController extends CrudController
{
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

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'politician_id',
                    'name' => ['Article Title'],
                    'approved',
                    'published',
                ],
                'actions' => ['index', 'view', 'add', 'edit', 'delete'],
                'breadcrumbs' => [
                    new Breadcrumb('Politicians', '/admin/users?role=politician'),
                    new Breadcrumb('Articles'),
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'breadcrumbs' => [
                    new Breadcrumb('Politicians', '/admin/users?role=politician'),
                    new Breadcrumb('Articles', '/admin/politician-articles'),
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

<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Controller\CrudController;
use OurSociety\Listener\ViewListener;
use Psr\Http\Message\ResponseInterface as Response;

class PositionsController extends CrudController
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
                    new Breadcrumb('Positions'),
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
                    new Breadcrumb('Positions', '/admin/politician-positions'),
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function edit(): ?Response
    {
        return $this->Crud->execute();
    }
}

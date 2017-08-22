<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Listener\ViewListener;
use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\CrudController;

/**
 * CohortsController.
 */
class CohortsController extends CrudController
{
    public function beforeFilter(Event $event)
    {
        $this->Crud->mapAction('dashboard', ['className' => DashboardAction::class]);

        parent::beforeFilter($event);
    }

    public function dashboard(): ?Response
    {
        $this->Crud->removeListener(ViewListener::class);

        return $this->Crud->execute();
    }
}

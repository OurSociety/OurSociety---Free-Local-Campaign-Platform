<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Listener\ViewListener;
use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\CrudController;

/**
 * AnalyticsController.
 *
 * @property AnalyticsTable $Analytics
 */
class AnalyticsController extends CrudController
{
    public function beforeFilter(Event $event): void
    {
        $this->Crud->mapAction('dashboard', ['className' => DashboardAction::class]);
        $this->Crud->removeListener(ViewListener::class);

        parent::beforeFilter($event);
    }

    public function dashboard(): ?Response
    {
        return $this->Crud->execute();
    }
}

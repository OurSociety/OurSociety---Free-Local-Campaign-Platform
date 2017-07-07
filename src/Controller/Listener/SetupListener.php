<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Listener;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class SetupListener implements EventListenerInterface
{

    public function implementedEvents(): array
    {
        return [
            'Controller.initialize' => 'redirectNewUser',
        ];
    }

    /**
     * Redirect new user.
     *
     * @param Event $event
     */
    public function redirectNewUser(Event $event): void
    {
        $controller = $event->getSubject();
        //$user = $controller->Auth->user();
        //$action = $controller->request->param('action');

        $controller->Flash->set(__('Welcome to OurSociety!'));
        $controller->redirect(['_name' => 'admin:dashboard']);
    }
}

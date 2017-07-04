<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\Http\Response;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler');
    }

    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event): ?Response
    {
        return null;
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Http\Response|null
     */
    public function beforeRender(Event $event): ?Response
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setTemplatePath('Error');

        return null;
    }

    /**
     * afterFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function afterFilter(Event $event)
    {
    }
}

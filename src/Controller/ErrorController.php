<?php
declare(strict_types = 1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
final class ErrorController extends AppController
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
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return Response|null
     */
    public function beforeRender(Event $event): ?Response
    {
        parent::beforeRender($event);

        $this->viewBuilder()->setTemplatePath('Error');

        return null;
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Psr\Http\Message\ResponseInterface as Response;

class PlansController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow('index');
    }

    public function index(): ?Response
    {
        $this->set('containerClass', 'container-fluid');

        return null;
    }
}

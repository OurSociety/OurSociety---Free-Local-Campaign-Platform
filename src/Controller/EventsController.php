<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use OurSociety\Model\Table\EventsTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * EventsController.
 *
 * @property EventsTable $Events
 */
class EventsController extends CrudController
{
    public function beforeFilter(Event $event): void
    {
        $this->viewBuilder()->setLayout('site');

        parent::beforeFilter($event);
    }

    public function index($eventSlug): ?Response
    {
        $this->set([
            'municipality' => $this->Events->ElectoralDistricts->find('slugged', ['slug' => $eventSlug])->firstOrFail(),
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) use ($eventSlug) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query->matching('ElectoralDistricts', function (Query $query) use ($eventSlug) {
                return $query->where(['ElectoralDistricts.slug' => $eventSlug]);
            });
        });

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }
}

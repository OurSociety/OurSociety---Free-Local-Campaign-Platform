<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use OurSociety\Model\Entity;
use OurSociety\Model\Table\ArticlesTable;
use OurSociety\Model\Table\EventsTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * EventsController.
 *
 * @property EventsTable $Events
 */
class EventsController extends CrudController
{
    public function index($municipalitySlug): ?Response
    {
        $this->set([
            'municipality' => $this->Events->ElectoralDistricts->find('slugged', ['slug' => $municipalitySlug])->firstOrFail(),
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) use ($municipalitySlug) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query->matching('ElectoralDistricts', function (Query $query) use ($municipalitySlug) {
                return $query->where(['ElectoralDistricts.slug' => $municipalitySlug]);
            });
        });

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }

    public function add(string $municipalitySlug): ?Response
    {
        return $this->_form($municipalitySlug);
    }

    public function edit(string $eventId, string $municipalitySlug): ?Response
    {
        return $this->_form($municipalitySlug);
    }

    private function _form(string $municipalitySlug): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name' => ['label' => 'Event Title'],
                    'location' => ['label' => 'Event Location'],
                    'category_id' => ['label' => 'Event Aspect'],
                    'start' => [
                        'label' => 'Event Date & Time',
                        'minYear' => date('Y'),
                        'maxYear' => date('Y') + 1,
                    ],
                    'description' => ['label' => 'Event Information'],
                ],
                'form_submit_button_text' => 'Save Event',
                'form_submit_extra_buttons' => false,
            ],
        ]);

        $getMunicipalityId = function () use ($municipalitySlug): string {
            /** @var ArticlesTable $table */
            $table = $this->loadModel();
            /** @var Entity\ElectoralDistrict $municipality */
            $municipality = $table->ElectoralDistricts->find('slugged', ['slug' => $municipalitySlug])->firstOrFail();

            return $municipality->id;
        };

        $this->Crud->on('beforeSave', function (Event $event) use ($getMunicipalityId) {
            /** @var Entity\Event $event */
            $event = $event->getSubject()->entity;
            /** @var Entity\User $user */
            $user = $this->Auth->user();

            $event->user_id = $user->id;
            $event->electoral_district_id = $getMunicipalityId();
        });

        $this->Crud->on('beforeRedirect', function (Event $event) use ($municipalitySlug) {
            if ($event->getSubject()->success !== true) {
                return null;
            }

            return $this->redirect(['_name' => 'municipality', 'municipality' => $municipalitySlug]);
        });

        return $this->Crud->execute();
    }
}

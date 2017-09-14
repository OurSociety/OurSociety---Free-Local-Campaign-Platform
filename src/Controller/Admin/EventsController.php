<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Events Controller
 */
class EventsController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'electoral_district_id' => [],
                    'name' => [],
                    'user_id' => [],
                    'start' => [],
                    'created' => [],
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

    private function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'electoral_district_id' => ['label' => 'Municipality'],
                    'user_id' => ['label' => 'Politician'],
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

        return $this->Crud->execute();
    }
}

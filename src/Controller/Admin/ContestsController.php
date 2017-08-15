<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Contests Controller
 */
class ContestsController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    //'name',
                    //'date',
                    //'state_id',
                    //'is_state_wide',
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
                    //'name',
                    //'date',
                    //'election_type',
                    //'state_id',
                    //'is_state_wide',
                    //'registration_info',
                    //'absentee_ballot_info',
                    //'results_uri',
                    //'has_election_day_registration',
                    //'registration_deadline',
                    //'absentee_request_deadline'
                ],
            ],
        ]);

        return $this->Crud->execute();
    }
}

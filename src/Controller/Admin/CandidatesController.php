<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use OurSociety\Controller\AppController;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\CrudController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Elections Controller
 */
class CandidatesController extends CrudController
{
    public function index(): ?Response
    {
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
                    'contest_id' => ['label' => 'Contest'],
                    'user_id' => ['label' => 'Politician'],
                ],
            ],
        ]);

        return $this->Crud->execute();
    }
}

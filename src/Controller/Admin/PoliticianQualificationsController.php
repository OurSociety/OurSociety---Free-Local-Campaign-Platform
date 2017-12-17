<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\Qualification;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Qualifications Controller
 *
 * @method Qualification[] paginate($object = null, array $settings = [])
 */
class PoliticianQualificationsController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'PoliticianQualifications';
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'politician_id',
                    'name' => ['title' => 'Qualification Title'],
                    'institution' => ['title' => 'Institution Name'],
                    'started' => ['title' => 'Date Started'],
                    'ended' => ['title' => 'Date Ended'],
                ],
                'breadcrumbs' => [
                    new Breadcrumb('Politicians', '/admin/users?role=politician'),
                    new Breadcrumb('Qualifications'),
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(): ?Response
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
                    'name' => ['label' => 'Qualification Title'],
                    'institution' => ['label' => 'Institution Name'],
                    'started' => ['label' => 'Date Started'] + $this->getFieldOptionsForYearMonth(),
                    'ended' => ['label' => 'Date Ended'] + $this->getFieldOptionsForYearMonth(),
                ],
            ],
        ]);

        return $this->Crud->execute();
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use Cake\Utility\Text;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\PoliticianAward;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Awards Controller
 *
 * @method PoliticianAward[] paginate($object = null, array $settings = [])
 */
class PoliticianAwardsController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'politician_id',
                    'name' => ['title' => 'Award Title'],
                    'description' => ['title' => 'Description of Award'],
                    'obtained' => ['title' => 'Date Obtained'],
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
                    'name' => ['label' => 'Award Title'],
                    'description' => ['label' => 'Description of Award'],
                    'obtained' => ['label' => 'Date Obtained'] + $this->getFieldOptionsForYearMonth(),
                ],
            ]
        ]);

        return $this->Crud->execute();
    }
}

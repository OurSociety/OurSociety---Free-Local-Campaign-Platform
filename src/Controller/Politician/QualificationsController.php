<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use Cake\Event\Event;
use Cake\Utility\Text;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\PoliticianQualification;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Qualifications Controller
 *
 * @method PoliticianQualification[] paginate($object = null, array $settings = [])
 */
class QualificationsController extends CrudController
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
                    'name' => ['title' => 'Qualification Title'],
                    'institution' => ['title' => 'Institution Name'],
                    'started' => ['title' => 'Date Started'],
                    'ended' => ['title' => 'Date Ended'],
                ],
            ],
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) {
            $event->getSubject()->query = $event->getSubject()->query->where([
                'Politicians.slug' => $this->Auth->user('slug'),
            ]);
        });

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
                    'started' => ['label' => 'Date Started'],
                    'ended' => ['label' => 'Date Ended'],
                ],
            ]
        ]);

        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianQualification $qualification */
            $qualification = $event->getSubject()->entity;
            $qualification->id = Text::uuid();
            $qualification->politician_id = $this->Auth->user('id');
        });

        return $this->Crud->execute();
    }
}

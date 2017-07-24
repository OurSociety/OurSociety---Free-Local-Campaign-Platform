<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use Cake\Event\Event;
use Cake\Utility\Text;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\PoliticianPosition;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Positions Controller
 *
 * @method PoliticianPosition[] paginate($object = null, array $settings = [])
 */
class PositionsController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'PoliticianPositions';
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name' => ['title' => 'Position Title'],
                    'company' => ['title' => 'Company Name'],
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
                    'name' => ['label' => 'Position Title'],
                    'company' => ['label' => 'Company Name'],
                    'started' => ['label' => 'Date Started'] + $this->getFieldOptionsForYearMonth(),
                    'ended' => ['label' => 'Date Ended'] + $this->getFieldOptionsForYearMonth(),
                ],
            ]
        ]);

        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianPosition $position */
            $position = $event->getSubject()->entity;
            $position->id = Text::uuid();
            $position->politician_id = $this->Auth->user('id');
        });

        return $this->Crud->execute();
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician\Profile;

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
class AwardsController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'PoliticianAwards';
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name' => ['title' => 'Award Title'],
                    'description' => ['title' => 'Description of Award'],
                    'obtained' => ['title' => 'Date Obtained'],
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
                    'name' => ['label' => 'Award Title'],
                    'description' => ['label' => 'Description of Award'],
                    'obtained' => ['label' => 'Date Obtained'] + $this->getFieldOptionsForYearMonth(),
                ],
            ]
        ]);

        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianAward $award */
            $award = $event->getSubject()->entity;
            $award->id = Text::uuid();
            $award->politician_id = $this->Auth->user('id');
        });

        return $this->Crud->execute();
    }
}

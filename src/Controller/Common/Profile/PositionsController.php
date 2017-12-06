<?php
declare(strict_types=1);

namespace OurSociety\Controller\Common\Profile;

use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\ORM\Query;
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
                'actions_blacklist' => ['export'],
                'fields' => [
                    'name' => ['title' => 'Position Title'],
                    'company' => ['title' => 'Company Name'],
                    'started' => ['title' => 'Date Started', 'formatter' => function ($field, $value) {
                        /** @var Date $value */
                        return $value ? $value->format('M Y') : null;
                    }],
                    'ended' => ['title' => 'Date Ended', 'formatter' => function ($field, $value) {
                        /** @var Date $value */
                        return $value ? $value->format('M Y') : null;
                    }],
                ],
            ],
        ]);

        $this->Crud->on('beforePaginate', function (Event $event) {
            $event->getSubject()->query = $event->getSubject()->query
                ->matching('Politicians', function (Query $query): Query {
                    return $query->where(['Politicians.slug' => $this->getIdentity()->slug]);
                });
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
                'actions_blacklist' => ['export'],
                'fields' => [
                    'name' => ['label' => 'Position Title'],
                    'company' => ['label' => 'Company Name'],
                    'started' => ['label' => 'Date Started'] + $this->getFieldOptionsForYearMonth(),
                    'ended' => ['label' => 'Date Ended'] + $this->getFieldOptionsForYearMonth(),
                ],
            ],
        ]);

        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianPosition $position */
            $position = $event->getSubject()->entity;
            $position->id = Text::uuid();
            $position->politician_id = $this->getIdentity()->id;
        });

        return $this->Crud->execute();
    }
}

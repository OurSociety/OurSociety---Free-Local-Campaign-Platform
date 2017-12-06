<?php
declare(strict_types=1);

namespace OurSociety\Controller\Common\Profile;

use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\ORM\Query;
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
                'actions_blacklist' => ['export'],
                'fields' => [
                    'name' => ['title' => 'Award Title'],
                    'description' => ['title' => 'Description of Award'],
                    'obtained' => ['title' => 'Date Obtained', 'formatter' => function ($field, $value) {
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
                    'name' => ['label' => 'Award Title'],
                    'description' => ['label' => 'Description of Award'],
                    'obtained' => ['label' => 'Date Obtained'] + $this->getFieldOptionsForYearMonth(),
                ],
            ],
        ]);

        $this->Crud->on('beforeSave', function (Event $event) {
            /** @var PoliticianAward $award */
            $award = $event->getSubject()->entity;
            $award->id = Text::uuid();
            $award->politician_id = $this->getIdentity()->id;
        });

        return $this->Crud->execute();
    }
}

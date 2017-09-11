<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Crud\Listener\ApiListener;
use OurSociety\Controller\Action\IndexAction;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Table\ElectoralDistrictsTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Municipalities Controller
 *
 * @property ElectoralDistrictsTable $Municipalities
 */
class MunicipalitiesController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'ElectoralDistricts';

        if ($this->request->getParam('action') === 'view' && $this->request->getParam('municipality') !== false) {
            $this->Auth->allow(['view']);
        }

        $this->Crud->mapAction('articles', IndexAction::class);
    }

    /**
     * @route GET /municipalities/lookup
     * @routeName municipality:lookup
     */
    public function lookup(): ?Response
    {
        $this->Crud->addListener('api', ApiListener::class);

        $this->Crud->on('beforeLookup', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query
                ->where([
                    array_values($query->aliasField('name'))[0] . ' LIKE' => '%' . $this->request->getQuery('name') . '%',
                ])
                ->matching('DistrictTypes', function (Query $query) {
                    return $query->where(['id_vip' => 'municipality']);
                })
                ->contain(['Parents']);
        });

        return $this->Crud->execute();
    }

    public function view(?string $municipalitySlug = null): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) use ($municipalitySlug) {
            if ($municipalitySlug !== null) {
                return;
            }

            $event->getSubject()->query = ElectoralDistrictsTable::instance()->find()->where([
                'id' => $this->getCurrentUser()->electoral_district_id,
            ]);
        });

        $this->Crud->on('beforeRender', function (Event $event) {
            /** @var ElectoralDistrict $electoralDistrict */
            $electoralDistrict = $event->getSubject()->entity;
            if ($electoralDistrict->isMunicipality()) {
                $this->viewBuilder()->setLayout('site');
            }
        });

        return $this->Crud->execute();
    }

    public function articles(string $slug): ?Response
    {
        $this->viewBuilder()->setLayout('site'); // TODO: Remove when default layout is Bootstrap 4.

        $this->set([
            'municipality' => $this->loadModel()->find()->where(['slug' => $slug])->firstOrFail(),
        ]);

        $this->modelClass = 'Articles';
        $this->Crud->action()->setConfig([
            'viewVar' => 'articles',
        ]);

        return $this->Crud->execute();
    }

    public function edit(string $municipalitySlug): ?Response
    {
        $this->Crud->action()->setConfig([
            'relatedModels' => false,
            'scaffold' => [
                'actions' => [],
                'form_submit_button_text' => 'Update Town Information',
                'form_submit_extra_buttons' => false,
                'fields' => [
                    'description' => ['placeholder' => 'Town Information', 'label' => false]
                ],
            ],
        ]);

        $this->Crud->on('beforeRedirect', function (Event $event) use ($municipalitySlug) {
            if ($event->getSubject()->success !== true) {
                return null;
            }

            return $this->redirect(['_name' => 'municipality', 'municipality' => $municipalitySlug]);
        });

        return $this->Crud->execute();
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Crud\Listener\ApiListener;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Table\MunicipalitiesTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Municipalities Controller
 *
 * @property MunicipalitiesTable $Municipalities
 */
class MunicipalitiesController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'ElectoralDistricts';
        $this->Auth->allow(['view']);
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

    public function view(): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query->contain([
                'Children' => ['DistrictTypes'],
                'Contests' => ['Elections'],
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
}

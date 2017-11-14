<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Crud\Listener\ApiListener;
use OurSociety\Model\Entity\ElectoralDistrict;
use OurSociety\Model\Table\ElectoralDistrictsTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * ElectoralDistricts Controller
 *
 * @property ElectoralDistrictsTable $ElectoralDistricts
 */
class ElectoralDistrictsController extends CrudController
{
    /**
     * @route GET /place/lookup
     * @routeName district:lookup
     */
    public function lookup(): ?Response
    {
        if ($this->hasIdentity() === false) {
            return $this->unauthorizedRedirect();
        }

        $this->Crud->addListener('api', ApiListener::class);

        $this->Crud->on('beforeLookup', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query
                ->select([
                    'name',
                ])
                ->where([
                    array_values($query->aliasField('name'))[0] . ' LIKE' => '%' . $this->request->getQuery('name') . '%',
                ])
                ->matching('DistrictTypes', function (Query $query) {
                    return $query->where(['id_vip' => 'municipality']);
                })
                ->contain(['Parents' => function (Query $query) {
                    return $query->select(['name']);
                }]);
        });

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query
                ->contain([
                    'Children' => ['DistrictTypes'],
                    'Contests' => ['Elections'],
                ]);
        });

        $this->Crud->on('beforeRender', function (Event $event) {
            /** @var ElectoralDistrict $place */
            $place = $event->getSubject()->entity;
            if ($place->isMunicipality()) {
                return $this->redirect(['_name' => 'municipality', 'municipality' => $place->slug]);
            }
        });

        return $this->Crud->execute();
    }
}

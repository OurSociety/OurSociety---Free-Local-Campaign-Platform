<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Crud\Listener\ApiListener;
use OurSociety\Model\Table\ElectoralDistrictsTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * ElectoralDistricts Controller
 *
 * @property ElectoralDistrictsTable $ElectoralDistricts
*/
class ElectoralDistrictsController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->allow(['view']);
    }

    /**
     * @route GET /district/lookup
     * @routeName district:lookup
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

        //$this->Crud->on('beforeRender', function (Event $event) {
        //    /** @var ElectoralDistrict $electoralDistrict */
        //    $electoralDistrict = $event->getSubject()->entity;
        //    if ($electoralDistrict->isMunicipality()) {
        //        //$this->viewBuilder()->setLayout('site');
        //        //$this->viewBuilder()->setTemplatePath(ROOT . 'src' . DS . 'Template' . DS . 'ElectoralDistricts');
        //        $this->Crud->disable('view');
        //        $this->render('municipality', 'site');
        //    }
        //});

        return $this->Crud->execute();
    }
}

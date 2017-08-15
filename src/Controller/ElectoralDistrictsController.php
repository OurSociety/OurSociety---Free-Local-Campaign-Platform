<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
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

        return $this->Crud->execute();
    }
}

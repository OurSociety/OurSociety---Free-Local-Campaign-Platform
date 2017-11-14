<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Event\Event;
use Cake\ORM\Query;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Contests Controller
 */
class ContestsController extends CrudController
{
    public function view(): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query->contain(['ElectoralDistricts' => ['DistrictTypes']]);
        });

        return $this->Crud->execute();
    }
}

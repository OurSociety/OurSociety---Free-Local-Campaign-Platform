<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * PathwayPolitician Controller
 */
class PathwayPoliticiansController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'Users';
        $this->Auth->allow('view');
    }

    public function view($citizenSlug): ?Response
    {
        $this->Crud->action()->setConfig(['viewVar' => 'politician', 'findMethod' => 'pathwayPolitician']);

        return $this->Crud->execute();
    }
}

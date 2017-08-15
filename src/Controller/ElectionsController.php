<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Elections Controller
 */
class ElectionsController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->Auth->allow(['index', 'view']);
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name',
                    'date',
                    'state_id',
                    'is_state_wide',
                ],
                'actions' => [
                    'view',
                ],
            ],
        ]);

        return $this->Crud->execute();
    }
}

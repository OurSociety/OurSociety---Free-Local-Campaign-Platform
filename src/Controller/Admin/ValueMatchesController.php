<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\ValueMatch;
use Psr\Http\Message\ResponseInterface as Response;

class ValueMatchesController extends CrudController
{
    public function beforeFilter(Event $event): void
    {
        $this->Crud->mapAction('dashboard', ['className' => DashboardAction::class]);

        parent::beforeFilter($event);
    }

    public function dashboard(): ?Response
    {
        return $this->Crud->execute();
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'actions' => ['index', 'view'],
                'fields' => [
                    'citizen_id',
                    'politician_id',
                    'category_id' => [
                        'formatter' => function (string $name, ?string $value, ValueMatch $entity) {
                            return $value ?? 'All Categories';
                        },
                    ],
                    'sample_size' => ['title' => '# Common Questions'],
                    'true_match_percentage' => [
                        'title' => 'Value Match',
                        'formatter' => function (string $name, string $value, ValueMatch $entity) {
                            return $value . '%';
                        },
                    ],
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        return $this->Crud->execute();
    }

    public function edit(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields_blacklist', ['created']);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        return $this->Crud->execute();
    }
}

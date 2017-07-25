<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\View\CellTrait;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Politicians Controller
 *
 * @method User[] paginate($object = null, array $settings = [])
 */
class PoliticiansController extends CrudController
{
    use CellTrait;

    /**
     * @var UsersTable
     */
    public $Users;

    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'Users';
        $this->Auth->allow(['index', 'view']);
    }

    public function index(): ?Response
    {
        $this->Crud->action()->setConfig([
            'findMethod' => 'politicianForCitizen',
            'scaffold' => [
                'fields' => [
                    'name',
                    'answer_count' => ['title' => '# Answers'],
                    'last_seen',
                ],
                'actions' => [
                    'view',
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function view(string $slug = null): ?Response
    {
        $this->set([
            'politician' => $this->loadModel('Users')->find('politicianForCitizen')->where([
                'slug' => $slug ?: $this->Auth->user('slug'),
            ])->firstOrFail(),
        ]);

        return null;
    }
}

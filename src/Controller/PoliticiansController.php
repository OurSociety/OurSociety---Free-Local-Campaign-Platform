<?php
declare(strict_types=1);

namespace OurSociety\Controller;

use Cake\Network\Exception\NotFoundException;
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
        $this->Auth->allow(['index', 'view', 'claim']);
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

    public function claim(string $slug = null): ?Response
    {
        /** @var UsersTable $users */
        $users = $this->loadModel('Users');
        $politician = $users->getBySlug($slug);

        if ($politician->isClaimed()) {
            throw new NotFoundException('This profile has been claimed.');
        }

        if ($this->request->is(['put', 'post'])) {
            if ($this->request->getData('token') !== $politician->token) {
                $politician->setError('token', 'Sorry, the code you have entered does not match our records.');
            } else {
                $entity = $this->Users->patchEntity($politician, [
                    'email' => $this->request->getData('email'),
                ]);
                if (empty($entity->getErrors())) {
                    $saved = $this->Users->save($this->Users->patchEntity($politician, [
                        'email' => $this->request->getData('email'),
                    ]));
                    if ($saved) {
                        $this->refreshAuth($politician);
                        $this->Flash->success(sprintf(
                            'You have claimed the profile of %s and are now logged in. Please update the remaining sections.',
                            $politician->name
                        ));
                        return $this->redirect(['_name' => 'politician:profile']);
                    }
                }
            }
        }

        unset($politician->token, $politician->password);

        $this->set(compact('politician'));

        return null;
    }
}

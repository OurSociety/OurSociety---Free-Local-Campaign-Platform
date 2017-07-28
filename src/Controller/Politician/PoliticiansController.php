<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use Cake\Event\Event;
use Cake\ORM\Query;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Politicians Controller
 *
 * @method User[] paginate($object = null, array $settings = [])
 */
class PoliticiansController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->modelClass = 'Users';
        $this->Crud->disable(['index', 'delete']);
    }

    public function view(): ?Response
    {
        /** @var User $politician */
        $politician = $this->loadModel('Users')
            ->find('politician')
            ->where(['slug' => $this->Auth->user('slug')])
            ->firstOrFail();

        if ($politician->verified === null) {
            $this->Flash->warning('The email address for this profile has not been verified.');
        }

        $this->set([
            'politician' => $politician,
        ]);

        return null;
    }

    public function edit(): ?Response
    {
        $this->Crud->on('beforeFind', function (Event $event) {
            /** @var Query $query */
            $query = $event->getSubject()->query;
            $query->where(['Users.id' => $this->Auth->user('id')], [], true);
        });

        $this->Crud->on('afterSave', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->Auth->refreshSession();
            }
        });

        $this->Crud->on('beforeRedirect', function (Event $event) {
            $event->getSubject()->url = ['_name' => 'politician:profile'];
        });

        return $this->Crud->execute();
    }
}

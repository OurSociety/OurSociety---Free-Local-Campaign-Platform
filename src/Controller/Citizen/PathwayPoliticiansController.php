<?php
declare(strict_types=1);

namespace OurSociety\Controller\Citizen;

use Cake\Event\Event;
use Cake\ORM\Query;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * PathwayPolitician Controller
 */
class PathwayPoliticiansController extends CrudController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('site'); // TODO: Remove when default layout is Bootstrap 4.
        $this->modelClass = 'Users';
    }

    public function view(): ?Response
    {
        /** @var User $politician */
        $politician = $this->loadModel('Users')
            ->find('pathwayPolitician')
            ->where(['slug' => $this->Auth->user('slug')])
            ->firstOrFail();

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
            $event->getSubject()->url = ['_name' => 'citizen:profile'];
        });

        return $this->Crud->execute();
    }
}

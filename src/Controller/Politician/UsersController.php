<?php
declare(strict_types=1);

namespace OurSociety\Controller\Politician;

use Cake\Event\Event;
use OurSociety\Controller\Action\RegisterAction;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\ORM\TableRegistry;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property UsersTable $Users
 */
class UsersController extends CrudController
{
    /**
     * {@inheritdoc}
     *
     * - Map actions to CrudUsers plugin.
     * - Allow public access to register page.
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Crud->mapAction('register', RegisterAction::class);
        //$this->Auth->allow(['register']); // TODO: Prevent AuthorizationMiddleware from blocking requests to register action
    }

    /**
     * @route GET /politician/register
     * @routeName politician:register
     */
    public function register(): ?Response
    {
        $this->Crud->on('afterRegister', function (Event $event) {
            if ($event->getSubject()->success === true) {
                /** @var User $user */
                $user = $event->getSubject()->entity;
                $this->authenticateIdentity($user->id);
                $this->Crud->action()->setConfig(['redirectUrl' => ['_name' => 'politician:profile']]);
            }
        });

        $this->Crud->on('beforeRedirect', function(\Cake\Event\Event $event) {
            if ($event->getSubject()->created && !$event->getSubject()->entity->incumbent) {
                $contests = $this->loadModel('Contests')->find('all');
                $candidatesTable = TableRegistry::get('Candidates');
                foreach ($contests as $contest){

                    /** @var \OurSociety\Model\Entity\Candidate $candidate */
                    $candidate = $candidatesTable->newEntity();
                    $candidate->politician = $event->getSubject()->entity;
                    $candidate->contest = $contest;
                    $candidate->is_incumbent = 0;
                    $candidatesTable->save($candidate);
                }
            }
        });
        return $this->Crud->execute();
    }
}

<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Politician;

use Cake\Event\Event;
use OurSociety\Controller\Action\RegisterAction;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Table\UsersTable;
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
        $this->Auth->allow(['register']);
    }

    /**
     * @route GET /politician/register
     * @routeName politician:register
     */
    public function register(): ?Response
    {
        $this->Crud->on('afterRegister', function (Event $event) {
            if ($event->getSubject()->success === true) {
                $this->Auth->refreshSession($event->getSubject()->entity);
                $this->Crud->action()->setConfig(['redirectUrl' => ['_name' => 'politician:profile']]);
            }
        });

        return $this->Crud->execute();
    }
}

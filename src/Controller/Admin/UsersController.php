<?php
declare(strict_types=1);

namespace OurSociety\Controller\Admin;

use Cake\Event\Event;
use CrudView\Breadcrumb\Breadcrumb;
use OurSociety\Controller\Action\DashboardAction;
use OurSociety\Controller\CrudController;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\ORM\TableRegistry;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * UsersController.
 *
 * @property UsersTable $Users
 */
class UsersController extends CrudController
{
    public function beforeFilter(Event $event)
    {
        $this->Crud->mapAction('dashboard', ['className' => DashboardAction::class]);

        parent::beforeFilter($event);
    }

    public function dashboard(): ?Response
    {
        $this->set([
            'recentlyCreatedUsers' => $this->Users->find('recentlyCreated'),
            'recentlyActiveUsers' => $this->Users->find('recentlyActive'),
            'citizenCount' => $this->Users->findByRole('citizen')->count(),
            'politicianCount' => $this->Users->findByRole('politician')->count(),
            'adminCount' => $this->Users->findByRole('admin')->count(),
            'cohortTable' => TableRegistry::get('Audits')->getCohorts(),
        ]);

        $this->Crud->action()->setConfig([
            'scaffold' => [
                'breadcrumbs' => [
                    new Breadcrumb('Users'),
                    new Breadcrumb('Dashboard'),
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function index(): ?Response
    {
        $this->Crud->addListener('CrudView.ViewSearch', ['enabled' => true]);

        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'name' => ['title' => 'Full Name'],
                    'role',
                    'answer_count' => ['title' => 'Answers'],
                    'email',
                    'last_seen',
                    'verified',
                ],
                'breadcrumbs' => [
                    new Breadcrumb('Dashboard', ['_name' => 'admin:users:dashboard']),
                    new Breadcrumb('Home'),
                ],
            ],
        ]);

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        return $this->_form();
    }

    public function edit(): ?Response
    {
        return $this->_form();
    }

    public function view(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'verified', 'created', 'modified']);

        return $this->Crud->execute();
    }

    public function switch(): ?Response
    {
        /** @var User $authAdmin */
        $authAdmin = $this->request->getSession()->read('Auth.Admin');

        /** @var User $user */
        $slug = $this->request->getData('user');
        $user = $slug !== null
            ? $this->loadModel('Users')->find('auth')->where(['slug' => $slug])->firstOrFail()
            : $authAdmin;

        if ($authAdmin === null) {
            $this->request->getSession()->write('Auth.Admin', $this->Auth->user());
            $this->Flash->warning(\__('You have assumed the identity of {name}.', ['name' => $user->name]));
        } elseif ($user->id === $authAdmin->id) {
            $this->request->getSession()->delete('Auth.Admin');
            $this->Flash->info(\__('Your identity has been reverted back to {name}.', ['name' => $user->name]));
        }

        $this->Auth->setUser($user);

        return $this->redirect(['_name' => \sprintf('%s:dashboard', $user->role)]);
    }

    public function export(): ?Response
    {
        return $this->Crud->execute();
    }

    protected function _form(): ?Response
    {
        $this->Crud->action()->setConfig([
            'scaffold' => [
                'fields' => [
                    'id' => ['type' => 'hidden'],
                ],
                'form_primary_tab' => 'User',
                'form_tab_groups' => [
                    'User' => [
                        'name' => ['label' => __('Full name')],
                        'email' => ['type' => 'email', 'label' => __('Email address')],
                        'role' => ['options' => array_combine(User::ROLES, User::ROLES)],
                        'verified' => ['type' => 'checkbox', 'label' => __('Email verified?')],
                        'electoral_district_id',
                        'phone' => ['type' => 'phone'],
                        'picture' => ['type' => 'file'],
                        'community_contributor',
                    ],
                    'Politician' => [
                        'address_1',
                        'address_2',
                        'city',
                        'state',
                        'zip',
                        'birth_name',
                        'birth_city',
                        'birth_state',
                        'birth_country',
                        'born' => ['empty' => true],
                        'position',
                        'office_type_id',
                        'incumbent',
                    ],
                ],
            ],
        ]);

        return $this->Crud->execute();
    }
}

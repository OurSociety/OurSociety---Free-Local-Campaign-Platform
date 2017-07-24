<?php
declare(strict_types = 1);

namespace OurSociety\Controller\Admin;

use Cake\Network\Exception\BadRequestException;
use OurSociety\Model\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;
use OurSociety\Controller\CrudController;

class UsersController extends CrudController
{
    public function index(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'created', 'modified', 'active']);

        return $this->Crud->execute();
    }

    public function add(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'active']);

        return $this->Crud->execute();
    }

    public function edit(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['id', 'name', 'email', 'active']);

        return $this->Crud->execute();
    }

    public function view(): ?Response
    {
        $this->Crud->action()->setConfig('scaffold.fields', ['name', 'email', 'active', 'created', 'modified']);

        return $this->Crud->execute();
    }

    public function switch(): ?Response
    {
        if (!$this->request->is(['put', 'post'])) {
            throw new BadRequestException('Only accepts PUT/POST requests.');
        }

        /** @var User $user */
        $user = $this->loadModel('Users')->find()->where(['slug' => $this->request->getData('user')])->firstOrFail();

        /** @var User $authAdmin */
        $authAdmin = $this->request->session()->read('Auth.Admin');

        if ($authAdmin === null) {
            $this->request->session()->write('Auth.Admin', $this->Auth->user());
            $this->Flash->warning(__('You have assumed the identity of {name}.', ['name' => $user->name]));
        } elseif ($user->id === $authAdmin->id) {
            $this->request->session()->delete('Auth.Admin');
            $this->Flash->info(__('Your identity has been reverted back to {name}.', ['name' => $user->name]));
        }

        $this->Auth->setUser($user);

        return $this->redirect(['_name' => sprintf('%s:dashboard', $user->role)]);
    }
}

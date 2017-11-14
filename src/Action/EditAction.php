<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\ORM\Exception\PersistenceFailedException;

abstract class EditAction extends Action
{
    public function __invoke(...$params): ?Response
    {
        $model = $this->getModel();
        $entity = $model->getByUniqueIdentifier($params[0]);

        if ($this->isSubmitRequest()) {
            try {
                $model->update($entity, $this->getRequestData());
                $this->setSuccessMessage($this->getSuccessMessage());

                return $this->redirect($this->getRedirectUrl());
            } catch (PersistenceFailedException $exception) {
                $this->setErrorMessage($this->getErrorMessage($exception->getEntity()));
            }
        }

        $questions = $model->Questions->find('list', ['limit' => 200]);
        $users = $model->Users->find('list', ['limit' => 200]);
        $this->setViewVariables(compact('entity', 'questions', 'users'));
        $this->setViewVariable('_serialize', ['report']);

        return null;
    }

    protected function getSuccessMessage(): string
    {
        return __('The {name} has been saved.', ['name' => $this->getSingularEntityName()]);
    }

    protected function getErrorMessage(EntityInterface $entity): string
    {
        return __('The {name} could not be saved. Please, try again.', ['name' => $this->getSingularEntityName()]);
    }

    protected function getRedirectUrl(): array
    {
        return ['action' => 'index'];
    }
}

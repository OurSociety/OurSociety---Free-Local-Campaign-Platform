<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\ORM\Exception\PersistenceFailedException;

abstract class EditAction extends Action
{
    use Traits\RecordIdentifierAwareTrait;

    public function __invoke(...$params): ?Response
    {
        $record = $this->getRecord($this->getRecordIdentifier($params));

        if ($this->isSubmitRequest()) {
            try {
                $this->getModel()->update($record, $this->getRequestData());
                $this->setSuccessMessage($this->getSuccessMessage());

                return $this->redirect($this->getRedirectUrl());
            } catch (PersistenceFailedException $exception) {
                $this->setErrorMessage($this->getErrorMessage($exception->getEntity()));
            }
        }

        $variables = compact('record') + $this->getModel()->getSelectFieldValues($this->getSelectFieldNames());

        $this->setViewVariables($variables);
        $this->setViewVariable('_serialize', array_keys($variables));
        $this->setViewTemplate($this->getViewTemplate());

        return null;
    }

    protected function getSuccessMessage(): string
    {
        return __('The {name} has been saved.', ['name' => $this->getSingularEntityName()]);
    }

    protected function getErrorMessage(EntityInterface $entity): string
    {
        return __('The {name} could not be saved.', ['name' => $this->getSingularEntityName()]);
    }

    protected function getRedirectUrl(): array
    {
        return ['action' => 'index'];
    }

    protected function getSelectFieldNames(): array
    {
        return [];
    }

    protected function getViewTemplate(): string
    {
        return 'edit';
    }
}

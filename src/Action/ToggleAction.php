<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\Network\Exception\BadRequestException;
use Cake\ORM\Exception\PersistenceFailedException;

abstract class ToggleAction extends Action
{
    public function __invoke(...$params): ?Response
    {
        if (!$this->isPostRequest()) {
            throw new BadRequestException();
        }

        try {
            $this->toggleFieldValue($this->getFieldName(), $params[0]);
            $this->setSuccessMessage($this->getSuccessMessage());
        } catch (PersistenceFailedException $exception) {
            $this->setErrorMessage($this->getErrorMessage($exception->getEntity()));
        }

        return $this->redirect($this->getRedirectUrl($params[0]));
    }

    abstract protected function getFieldName(): string;

    protected function getSuccessMessage(): string
    {
        return __('The {name} was marked as {field}.', [
            'name' => $this->getSingularEntityName(),
            'field' => $this->getFieldName(),
        ]);
    }

    protected function getErrorMessage(EntityInterface $entity): string
    {
        return __('The {name} could not be marked as {field}. Please, try again.', [
            'name' => $this->getSingularEntityName(),
            'field' => $this->getFieldName(),
        ]);
    }

    protected function getRedirectUrl(string $identifier): array
    {
        return ['action' => 'view', $identifier];
    }

    private function toggleFieldValue(string $fieldName, string $identifier): void
    {
        $model = $this->getModel();
        $entity = $model->getByUniqueIdentifier($identifier, [$fieldName]);

        $model->toggleField($entity, $fieldName);
    }
}

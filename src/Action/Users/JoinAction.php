<?php
declare(strict_types=1);

namespace OurSociety\Action\Users;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\ORM\Exception\PersistenceFailedException;
use OurSociety\Action\Action;
use OurSociety\Model\Users;

class JoinAction extends Action
{
    public const MESSAGE_SUCCESS = 'Your location has been stored.';

    /**
     * @route GET /sign-in
     * @routeName users:login
     */
    public function __invoke(...$params): ?Response
    {
        if ($this->hasIdentity()) {
            return $this->redirectToDashboard();
        }

        if ($this->isFormSubmission()) {
            try {
                $this->registerUser($this->getRequestData());
                $this->setSuccessMessage($this->getSuccessMessage());
            } catch (PersistenceFailedException $exception) {
                $this->setErrorMessage($this->getErrorMessage($exception->getEntity()));
            }
        }

        $this->setUserToView();
        $this->setBootstrapContainerToFluid();

        return null;
    }

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

    private function setUserToView(): void
    {
        $this->setViewVariable('user', $this->getModel()->getContext());
    }

    private function registerUser(array $requestData): void
    {
        /** @var Users $model */
        $model = $this->getModel();
        $model->register($requestData);
    }

    private function redirectToDashboard(): ?Response
    {
        return $this->redirect($this->getIdentity()->getDashboardRoute());
    }
}

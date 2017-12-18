<?php
declare(strict_types=1);

namespace OurSociety\Action\Users;

use Cake\Datasource\EntityInterface;

class EditAction extends \OurSociety\Action\EditAction
{
    public function getRecordIdentifier($params): string
    {
        return $this->getIdentity()->slug;
    }

    protected function getRedirectUrl(): array
    {
        return ['action' => 'profile'];
    }

    protected function getSuccessMessage(): string
    {
        return __('Your account changes have been saved.');
    }

    protected function getErrorMessage(EntityInterface $entity): string
    {
        return __('Your account changes could not be saved. Please, try again.');
    }
}

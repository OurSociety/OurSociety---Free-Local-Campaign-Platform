<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

final class CreateButton extends RepositoryButton
{
    public function getButtonTitle(): string
    {
        return __('Create');
    }

    protected function getButtonIcon(): string
    {
        return 'plus';
    }

    protected function getActionName(): string
    {
        return 'add';
    }

    protected function getButtonStyle(): string
    {
        return 'success';
    }
}

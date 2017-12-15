<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

final class DeleteButton extends RecordButton
{
    public function getButtonTitle(): string
    {
        return __('Delete');
    }

    public function getButtonOptions(): array
    {
        $options = [
            'confirm' => __('Are you sure you want to delete {name}?', [
                'name' => $this->getRecord()->getDisplayValue(),
            ]),
            'escape' => false, // Note: inverse value required to escape quotes in confirmation JS onclick handler.
        ];

        return $options + parent::getButtonOptions();
    }

    protected function getActionName(): string
    {
        return 'delete';
    }

    protected function getButtonIcon(): string
    {
        return 'trash';
    }

    protected function getButtonStyle(): string
    {
        return 'danger';
    }
}

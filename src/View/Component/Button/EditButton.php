<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

final class EditButton extends RecordButton
{
    public function getButtonTitle(): string
    {
        return __('Edit');
    }

    public function getButtonIcon(): string
    {
        return 'pencil';
    }

    protected function getActionName(): string
    {
        return 'edit';
    }

    protected function getButtonStyle(): string
    {
        return 'warning';
    }
}

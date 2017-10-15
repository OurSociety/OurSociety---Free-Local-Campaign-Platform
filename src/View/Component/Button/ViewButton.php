<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

final class ViewButton extends RecordButton
{
    public function getButtonTitle(): string
    {
        return __('View');
    }

    public function getButtonIcon(): string
    {
        return 'eye';
    }

    protected function getActionName(): string
    {
        return 'view';
    }

    protected function getButtonStyle(): string
    {
        return 'info';
    }
}

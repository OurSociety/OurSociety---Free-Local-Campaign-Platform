<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

final class ShowButton extends RecordButton
{
    public function getButtonTitle(): string
    {
        return __('Show');
    }

    public function getButtonIcon(): string
    {
        return 'eye';
    }

    protected function getActionName(): string
    {
        return 'show';
    }

    protected function getButtonStyle(): string
    {
        return 'info';
    }
}

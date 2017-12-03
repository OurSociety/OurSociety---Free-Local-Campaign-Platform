<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

final class EditButton extends RecordButton
{
    protected $buttonTitle;

    public function getButtonTitle(): string
    {
        return $this->buttonTitle ?? __('Edit');
    }

    public function getButtonIcon(): string
    {
        return 'pencil';
    }

    public function setButtonTitle(string $title): self
    {
        $this->buttonTitle = $title;

        return $this;
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

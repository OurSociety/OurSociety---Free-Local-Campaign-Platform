<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

use OurSociety\Model\Entity\RecordInterface;

final class ToggleButton extends RecordButton
{
    private $actionName;

    private $buttonTitle;

    private $recordFieldName;

    private $url;

    public function __construct(RecordInterface $record = null, array $options = null)
    {
        parent::__construct($record);

        $this->actionName = $options['action'] ?? 'toggle';
        $this->buttonTitle = $options['title'] ?? ['Toggle On', 'Toggle Off'];
        $this->recordFieldName = $options['field'] ?? 'published';
        $this->url = $options['url'] ?? null;
    }

    public function getButtonUrl(): array
    {
        return $this->url ?? parent::getButtonUrl();
    }

    public function getButtonTitle(): string
    {
        return __($this->buttonTitle[(int)$this->isToggled()]);
    }

    protected function getButtonIcon(): string
    {
        return $this->isToggled() ? 'toggle-on' : 'toggle-off';
    }

    protected function getActionName(): string
    {
        return $this->actionName;
    }

    protected function getButtonStyle(): string
    {
        return $this->isToggled() ? 'warning' : 'success';
    }

    private function isToggled(): bool
    {
        return (bool)$this->getRecord()->get($this->recordFieldName);
    }
}

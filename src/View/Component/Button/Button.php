<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Button;

use OurSociety\View\Component\Component;

abstract class Button extends Component
{
    public const SCOPE_RECORD = 'record';

    public const SCOPE_REPOSITORY = 'repository';

    abstract public function getButtonTitle(): string;

    abstract public function getButtonUrl(): array;

    public function getButtonOptions(): array
    {
        return [
            'class' => ['btn', sprintf('btn-%s', $this->getButtonStyle()), 'btn-sm'],
            'icon' => $this->getButtonIcon(),
            'aria-label' => $this->getButtonTitle(),
        ];
    }

    abstract public function getButtonScope(): string;

    public function hasButtonScope(string $scope = null): bool
    {
        return $scope === null || $this->getButtonScope() === $scope;
    }

    abstract protected function getButtonIcon(): string;

    abstract protected function getButtonStyle(): string;
}

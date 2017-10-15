<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

final class BooleanField extends Field
{
    public function isTrue(): bool
    {
        return $this->getValue() === true;
    }

    public function getIconName(): string
    {
        return $this->booleanSwitch('check', 'times', 'question');
    }

    public function getBadgeStyle(): string
    {
        return $this->booleanSwitch('success', 'danger', 'warning');
    }

    public function getBadgeTitle(): string
    {
        return $this->booleanSwitch(
            __('{status}', ['status' => ucfirst($this->getName())]),
            __('Not {status}', ['status' => $this->getName()]),
            __('{status} status unknown', ['status' => ucfirst($this->getName())])
        );
    }

    private function booleanSwitch($trueCase, $falseCase, $nullCase): string
    {
        switch ($this->getValue()) {
            case null:
                return $nullCase;
            case true:
                return $trueCase;
            case false:
                return $falseCase;
            default:
                throw new \InvalidArgumentException('Non-boolean value');
        }
    }
}

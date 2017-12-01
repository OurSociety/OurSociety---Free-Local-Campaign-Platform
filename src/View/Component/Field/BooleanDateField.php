<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

final class BooleanDateField extends BooleanField
{
    public function isTrue(): bool
    {
        return $this->getValue() !== null;
    }

    protected function booleanSwitch($trueCase, $falseCase, $nullCase): string
    {
        return $this->isTrue() ? $trueCase : $falseCase;
    }
}

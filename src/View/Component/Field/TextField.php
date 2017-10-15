<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

final class TextField extends Field
{
    public function getText()
    {
        return $this->getValue();
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

class TextField extends Field
{
    public function getText()
    {
        return $this->getValue();
    }
}

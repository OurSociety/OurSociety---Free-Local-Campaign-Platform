<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Field;

use DateTimeInterface;

final class DateField extends Field
{
    public function getDate(): DateTimeInterface
    {
        return $this->getValue();
    }
}

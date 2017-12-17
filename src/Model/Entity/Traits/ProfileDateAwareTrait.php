<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity\Traits;

use Cake\I18n\FrozenDate;

trait ProfileDateAwareTrait
{
    public function getMinDate(): FrozenDate
    {
        return $this->politician->born ?? FrozenDate::create(1990, 1, 1);
    }

    public function getMaxDate(): FrozenDate
    {
        return FrozenDate::now();
    }
}

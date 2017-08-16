<?php
declare(strict_types=1);

namespace OurSociety\Model\Behavior;

use Muffin\Orderly\Model\Behavior as Orderly;

class DefaultOrderBehavior extends Orderly\OrderlyBehavior
{
    /**
     * {@inheritdoc}. Unset class name as it breaks the parent method.
     */
    protected function _normalizeConfig($orders): void
    {
        unset($orders['className']);

        parent::_normalizeConfig($orders);
    }
}

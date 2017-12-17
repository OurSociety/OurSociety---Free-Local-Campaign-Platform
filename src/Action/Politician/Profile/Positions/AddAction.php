<?php
declare(strict_types=1);

namespace OurSociety\Action\Politician\Profile\Positions;

use OurSociety\Action\CreateAction;

class AddAction extends CreateAction
{
    protected function getRequestData($name = null, $default = null): array
    {
        return ['politician_id' => $this->getIdentity()->id] + parent::getRequestData();
    }
}

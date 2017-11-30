<?php
declare(strict_types=1);

namespace OurSociety\Action\Citizen\Notifications;

use OurSociety\Action\IndexAction;

class ListAction extends IndexAction
{
    protected function getDefaultFinderOptions(): array
    {
        return [
            'user' => $this->getIdentity(),
        ];
    }
}

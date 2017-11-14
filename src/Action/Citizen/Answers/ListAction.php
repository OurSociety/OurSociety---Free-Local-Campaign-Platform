<?php
declare(strict_types=1);

namespace OurSociety\Action\Citizen\Answers;

use OurSociety\Action\IndexAction;

class ListAction extends IndexAction
{
    protected function getDefaultFinderOptions(): array
    {
        return [
            'identity' => $this->getIdentity(),
        ];
    }
}

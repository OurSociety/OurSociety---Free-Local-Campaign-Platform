<?php
declare(strict_types=1);

namespace OurSociety\Action\Admin\Reports;

use OurSociety\Action;

class ToggleDoneAction extends Action\ToggleAction
{
    protected function getFieldName(): string
    {
        return 'done';
    }
}

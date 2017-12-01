<?php
declare(strict_types=1);

namespace OurSociety\Action\Admin\Articles;

class ToggleApprovedAction extends ToggleAction
{
    protected function getFieldName(): string
    {
        return 'approved';
    }
}

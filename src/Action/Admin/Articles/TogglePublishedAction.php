<?php
declare(strict_types=1);

namespace OurSociety\Action\Admin\Articles;

class TogglePublishedAction extends ToggleAction
{
    protected function getFieldName(): string
    {
        return 'published';
    }
}

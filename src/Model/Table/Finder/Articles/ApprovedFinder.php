<?php
declare(strict_types=1);

namespace OurSociety\Model\Table\Finder\Articles;

use OurSociety\Model\Table\Finder\BooleanDateFinder;

class ApprovedFinder extends BooleanDateFinder
{
    protected function getFieldName(): string
    {
        return 'approved';
    }

    protected function getBypassConditions(): array
    {
        return [
            $this->aliasField($this->query, 'politician_id') => $this->getIdentity($this->options)->id,
        ];
    }

    protected function hasBypassConditions(): bool
    {
        return $this->hasIdentity($this->options);
    }
}

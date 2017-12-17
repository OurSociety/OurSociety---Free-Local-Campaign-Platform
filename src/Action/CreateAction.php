<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Datasource\EntityInterface;

abstract class CreateAction extends EditAction
{
    public function getRecord(string $identifier): EntityInterface
    {
        return $this->getModel()->getNewEntity();
    }

    public function getRecordIdentifier($params): string
    {
        return '';
    }
}

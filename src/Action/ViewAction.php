<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;

class ViewAction extends Action
{
    public function __invoke(...$params): ?Response
    {
        $record = $this->getRecord($this->getRecordIdentifier($params));
        $this->afterFind($record);
        $this->setRecordToView($record);

        return null;
    }

    protected function getRecord(string $identifier): EntityInterface
    {
        return $this->getModel()->getQueryForAction($this, ['identifier' => $identifier])->firstOrFail();
    }

    protected function setRecordToView(EntityInterface $entity): void
    {
        $this->setViewVariable('record', $entity);
    }

    protected function getRecordIdentifier($params): string
    {
        return $params[0];
    }

    protected function afterFind(EntityInterface $record): void
    {
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Datasource\EntityInterface;
use Cake\Http\Response;

class ViewAction extends Action
{
    public function __invoke(...$params): ?Response
    {
        $this->setRecordToView($this->getRecord($params[0]));

        return null;
    }

    public function getRecord(string $identifier): EntityInterface
    {
        return $this->getModel()->getQueryForAction($this)->firstOrFail();
    }

    protected function setRecordToView(EntityInterface $entity): void
    {
        $this->setViewVariable('record', $entity);
    }
}

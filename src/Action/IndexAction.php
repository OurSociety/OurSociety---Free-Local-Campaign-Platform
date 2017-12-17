<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Http\Response;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;

abstract class IndexAction extends Action
{
    protected const VIEW_VARIABLE_RECORDS = 'records';

    public function __invoke(...$params): ?Response
    {
        $this->setRecordsToView($this->getResults());
        $this->serializeViewVariables($this->getSerializedViewVariables());

        return null;
    }

    protected function getPaginationQuery(): Query
    {
        return $this->getModel()->getQueryForAction($this, $this->getDefaultFinderOptions());
    }

    protected function getResults(): ResultSet
    {
        return $this->getResultsPage($this->getPaginationQuery());
    }

    protected function getSerializedViewVariables(): array
    {
        return [
            self::VIEW_VARIABLE_RECORDS,
        ];
    }

    protected function serializeViewVariables(array $variables): void
    {
        $this->setViewVariable('_serialize', $variables);
    }

    protected function setRecordsToView(ResultSet $records): void
    {
        $this->setViewVariable(self::VIEW_VARIABLE_RECORDS, $records);
    }

    protected function getDefaultFinderOptions(): array
    {
        return [
            'identity' => $this->hasIdentity() ? $this->getIdentity() : null,
        ];
    }
}

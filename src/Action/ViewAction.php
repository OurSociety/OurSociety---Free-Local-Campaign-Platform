<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\ORM\Query;

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
        return $this->getQuery($identifier)->firstOrFail();
    }

    protected function setRecordToView(EntityInterface $entity): void
    {
        $this->setViewVariable($this->getRecordViewVariable(), $entity);
    }

    protected function getRecordIdentifier($params): string
    {
        return $params[0];
    }

    protected function beforeFind(EntityInterface $record): EntityInterface
    {
    }

    protected function afterFind(EntityInterface $record): void
    {
    }

    protected function getFinderName(): string
    {
        $pattern = sprintf('#^%s\\\\Action\\\\((.+)\\\\)?[^\\\\]+?\\\\([^\\\\]+)$#', Configure::read('App.namespace'));
        $count = preg_match($pattern, static::class, $matches);
        if ($count !== 1) {
            throw new \RuntimeException(sprintf('Could not get finder name for class name "%s"', static::class));
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        [$subject, $prefixWithSlash, $prefix, $action] = $matches;

        return sprintf('for%s%s', $prefix, $action);
    }

    protected function getQuery(string $identifier): Query
    {
        return $this->getModel()->getQueryForAction($this, $this->getDefaultFinderOptions($identifier));
    }

    protected function getRecordViewVariable(): string
    {
        return 'record';
    }

    private function getDefaultFinderOptions(string $identifier): array
    {
        return ['identifier' => $identifier];
    }
}

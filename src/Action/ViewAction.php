<?php
declare(strict_types=1);

namespace OurSociety\Action;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;

abstract class ViewAction extends Action
{
    use Traits\RecordIdentifierAwareTrait;

    public function __invoke(...$params): ?Response
    {
        $record = $this->getRecord($this->getRecordIdentifier($params));
        $this->afterFind($record);
        $this->setRecordToView($record);

        return null;
    }

    protected function setRecordToView(EntityInterface $entity): void
    {
        $this->setViewVariable($this->getRecordViewVariable(), $entity);
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

    protected function getRecordViewVariable(): string
    {
        return 'record';
    }
}

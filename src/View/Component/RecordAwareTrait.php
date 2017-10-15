<?php
declare(strict_types=1);

namespace OurSociety\View\Component;

use OurSociety\Model\Entity\RecordInterface;

trait RecordAwareTrait
{
    /**
     * @var RecordInterface
     */
    private $record;

    //public function getModelSchema(): TableSchema
    //{
    //    return $this->record->getModel()->getSchema();
    //}
    //
    //public function getPrimaryKey(RecordInterface $record): string
    //{
    //    return $this->record->hasSlugField() ? $this->record->getSlugFieldName() : $this->record->getPrimaryKey();
    //}

    public function withRecord(RecordInterface $record): self
    {
        $field = clone $this;
        $field->setRecord($record);

        return $field;
    }

    public function getRecord(): RecordInterface
    {
        return $this->record;
    }

    protected function getRepositoryName(): string
    {
        return (string)$this->getRecord()->getSource();
    }

    private function setRecord(RecordInterface $record = null): void
    {
        $this->record = $record;
    }
}

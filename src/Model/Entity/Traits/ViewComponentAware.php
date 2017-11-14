<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity\Traits;

use Cake\Database\Schema\TableSchema;
use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;
use OurSociety\Model\Entity\RecordInterface;
use OurSociety\Model\Table\AppTable;
use OurSociety\View\Component\Field;

/**
 * View component aware trait.
 *
 * Satisfies the interface that view components type-hint entities against.
 *
 * @see RecordInterface
 */
trait ViewComponentAware
{
    use LazyLoadEntityTrait;

    /**
     * {@inheritdoc}
     */
    public function getDisplayFieldName(): string
    {
        return $this->getModel()->getDisplayField();
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayValue(): string
    {
        return $this->get($this->getDisplayFieldName());
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultFieldList(): Field\FieldList
    {
        return Field\FieldList::fromArray($this->getModel(), $this->getModelSchemaColumns());
    }

    /**
     * {@inheritdoc}
     */
    public function getModel(): AppTable
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->_repository();
    }

    /**
     * {@inheritdoc}
     */
    public function getModelSchema(): TableSchema
    {
        return $this->getModel()->getSchema();
    }

    /**
     * {@inheritdoc}
     */
    public function getModelSchemaColumns(): array
    {
        return $this->getModelSchema()->columns();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrimaryKey(): string
    {
        return $this->getModel()->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getSlugFieldName(): string
    {
        return $this->getModel()->getSlugFieldName();
    }

    /**
     * {@inheritdoc}
     */
    public function hasSlugField(): bool
    {
        return $this->getModel()->hasSlugField();
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifierFieldName(): string
    {
        return $this->hasSlugField() ? $this->getSlugFieldName() : $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifierValue(): string
    {
        return $this->get($this->getIdentifierFieldName());
    }

    /**
     * {@inheritdoc}
     */
    public function getModelAlias(): string
    {
        return $this->getModel()->getAlias();
    }
}

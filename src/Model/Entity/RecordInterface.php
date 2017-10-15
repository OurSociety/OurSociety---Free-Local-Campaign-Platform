<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface;
use OurSociety\Model\Table\AppTable;
use OurSociety\View\Component\Field;

interface RecordInterface extends EntityInterface
{
    public function getDisplayFieldName(): string;

    public function getDisplayValue(): string;

    public function getDefaultFieldList(): Field\FieldList;

    public function getModel(): AppTable;

    public function getModelSchema(): TableSchema;

    /**
     * @return string[]
     */
    public function getModelSchemaColumns(): array;

    public function getPrimaryKey(): string;

    public function getSlugFieldName(): string;

    public function hasSlugField(): bool;

    public function getIdentifierFieldName(): string;

    public function getIdentifierValue(): string;

    public function getModelAlias(): string;

    public function getIcon(): string;
}

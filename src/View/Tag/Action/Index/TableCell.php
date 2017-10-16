<?php
declare(strict_types=1);

namespace OurSociety\View\Tag\Action\Index;

use Cake\ORM\Entity;
use OurSociety\View\Scaffold\Field;
use OurSociety\View\Tag\Tag;

class TableCell extends Tag
{
    /**
     * @var TableRow
     */
    private $tableRow;

    /**
     * @var Field
     */
    private $field;

    /**
     * @var Entity
     */
    private $entity;

    public function __construct(TableRow $tableRow, Field $field, Entity $entity)
    {

        $this->tableRow = $tableRow;
        $this->field = $field;
        $this->entity = $entity;
    }

    public function printValue(): string
    {
        return (string)$this->entity->get($this->field->getName());
    }

    public function getTagName()
    {
        return $this->field->getCellTag($this->entity);
    }

    public function getPrimaryKey(): string
    {
        return $this->entity->id;
    }

    public function isDisplayField(): bool
    {
        return $this->field->isDisplayField($this->entity);
    }
}

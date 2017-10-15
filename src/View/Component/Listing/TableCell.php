<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Listing;

use OurSociety\Model\Entity\RecordInterface;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\Field;

final class TableCell extends Component
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
     * @var RecordInterface
     */
    private $record;

    public function __construct(TableRow $tableRow, Field $field, RecordInterface $record)
    {
        $this->tableRow = $tableRow;
        $this->field = $field;
        $this->record = $record;
    }

    public function getRecord(): RecordInterface
    {
        return $this->record;
    }

    public function getField(): Field
    {
        return $this->field;
    }

    public function getPrimaryKey(): string
    {
        return $this->record->id;
    }

    public function getTableRow(): TableRow
    {
        return $this->tableRow;
    }

    public function getTagName(): string
    {
        return $this->field->getCellTag($this->record);
    }

    public function isDisplayField(): bool
    {
        return $this->field->isDisplayField($this->record);
    }
}

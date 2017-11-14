<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Listing;

use Cake\Datasource\ResultSetInterface;
use OurSociety\View\Component\Button\RecordButton;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\FieldList;

final class TableBody extends Component
{
    /**
     * @var Table
     */
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function hasButtons(): bool
    {
        return $this->table->hasRecordButtons();
    }

    public function getFieldList(): FieldList
    {
        return $this->table->getFields();
    }

    public function getRecords(): ResultSetInterface
    {
        return $this->table->getRecords();
    }

    /**
     * @return RecordButton[]
     */
    public function getRecordButtons(): array
    {
        return $this->table->getRecordButtons();
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Listing;

use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\Field;
use OurSociety\View\Component\Field\FieldList;

final class TableHead extends Component
{
    /**
     * @var Table
     */
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @return FieldList|Field[]
     */
    public function getFieldList(): FieldList
    {
        return $this->table->getFields();
    }

    public function hasButtons(): bool
    {
        return $this->table->hasRecordButtons();
    }
}

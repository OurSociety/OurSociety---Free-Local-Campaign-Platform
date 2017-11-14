<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Listing;

use Cake\Datasource\ResultSetInterface;
use OurSociety\View\Component\Button\RecordButton;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\FieldList;

final class Table extends Component
{
    /**
     * @var array
     */
    private $recordButtons;

    /**
     * @var FieldList
     */
    private $fields;

    /**
     * @var ResultSetInterface
     */
    private $records;

    public function __construct(ResultSetInterface $records, FieldList $fields = null, array $recordButtons = null)
    {
        $this->records = $records;
        $this->fields = $fields;
        $this->recordButtons = $recordButtons;
    }

    public function getRecords(): ResultSetInterface
    {
        return $this->records;
    }

    public function hasRecordButtons(): bool
    {
        return count($this->recordButtons) > 0;
    }

    public function hasRecords(): bool
    {
        return $this->records->count() !== 0;
    }

    /**
     * @return FieldList
     */
    public function getFields(): FieldList
    {
        return $this->fields;
    }

    /**
     * @return RecordButton[]
     */
    public function getRecordButtons(): array
    {
        return $this->recordButtons;
    }
}

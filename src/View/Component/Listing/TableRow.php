<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Listing;

use Cake\ORM\Entity;
use OurSociety\Model\Entity\RecordInterface;
use OurSociety\View\Component\Button\ButtonGroup;
use OurSociety\View\Component\Button\RecordButton;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\FieldList;

final class TableRow extends Component
{
    /**
     * @var TableBody
     */
    private $tableBody;

    /**
     * @var Entity
     */
    private $record;

    public function __construct(TableBody $tableBody, RecordInterface $record)
    {
        $this->tableBody = $tableBody;
        $this->record = $record;
    }

    public function hasButtonGroup(): bool
    {
        return $this->tableBody->hasButtons();
    }

    public function getFieldList(): FieldList
    {
        return $this->tableBody->getFieldList();
    }

    public function getRecord(): Entity
    {
        return $this->record;
    }

    public function getButtonGroup(): ButtonGroup
    {
        $withRecord = function (RecordButton $recordButton) {
            return $recordButton->withRecord($this->getRecord());
        };

        $buttons = collection($this->tableBody->getRecordButtons())
            ->map($withRecord)
            ->toList();

        return new ButtonGroup($buttons);
    }
}

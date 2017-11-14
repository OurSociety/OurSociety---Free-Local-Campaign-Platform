<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Detail;

use OurSociety\Model\Entity\RecordInterface;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\Field;
use OurSociety\View\Component\Field\FieldList;
use OurSociety\View\Component\Layout\Icon;
use OurSociety\View\Component\NestedComponentAwareTrait;
use OurSociety\View\Component\RecordAwareTrait;

class Show extends Component
{
    use NestedComponentAwareTrait;
    use RecordAwareTrait;

    public function __construct(RecordInterface $record, array $components, string $title = null)
    {
        $this->setComponents($components);
        $this->setRecord($record);
    }

    public function getIcon(): Icon
    {
        return new Icon($this->getRecord()->getIcon());
    }

    public function buildField(Field $field): Field
    {
        return $field->withRecord($this->getRecord());
    }

    public function getRecordTitle(): string
    {
        return $this->getRecord()->getDisplayValue();
    }

    protected function getDefaultFields(): FieldList
    {
        return $this->getRecord()->getDefaultFieldList();
    }
}

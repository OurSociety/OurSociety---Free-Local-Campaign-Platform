<?php
declare(strict_types=1);

namespace OurSociety\View\Component\Listing;

use Cake\Datasource\ResultSetInterface;
use Cake\Utility\Inflector;
use OurSociety\Model\Entity\RecordInterface;
use OurSociety\View\Component\Component;
use OurSociety\View\Component\Field\FieldList;
use OurSociety\View\Component\NestedComponentAwareTrait;

final class Listing extends Component
{
    use NestedComponentAwareTrait;

    /**
     * @var string
     */
    private $heading;

    /**
     * @var ResultSetInterface
     */
    private $records;

    /**
     * @var RecordInterface
     */
    private $record;

    public function __construct(array $components, ResultSetInterface $records)
    {
        $this->setComponents($components);
        $this->records = $records;
    }

    /**
     * @return ResultSetInterface
     */
    public function getRecords(): ResultSetInterface
    {
        return $this->records;
    }

    public function getHeading(): string
    {
        return $this->heading ?? Inflector::humanize($this->getRepositoryName());
    }

    public function getRepositoryName(): string
    {
        return (string)$this->getRecord()->getSource();
    }

    public function getIcon(): string
    {
        return $this->getRecord()->getIcon();
    }

    public function setHeading(string $heading): self
    {
        $this->heading = $heading;

        return $this;
    }

    public function getEmptyMessage(): string
    {
        return __('There are no {name}.', [
            'name' => strtolower($this->getRecord()->getModelAlias()),
        ]);
    }

    protected function getDefaultFields(): FieldList
    {
        return $this->getRecord()->getDefaultFieldList();
    }

    /**
     * @return RecordInterface
     */
    private function getRecord(): RecordInterface
    {
        if ($this->record !== null) {
            return $this->record;
        }

        $this->record = $this->records->first();

        if ($this->record !== null) {
            return $this->record;
        }

        $recordClass = $this->getInternalPropertyValue($this->records, '_entityClass');
        $repositoryName = $this->getInternalPropertyValue($this->records, '_defaultAlias');

        /** @var RecordInterface $record */
        $record = new $recordClass;
        $record->setSource($repositoryName);

        return $this->record = $record;
    }

    private function getInternalPropertyValue($object, string $name)
    {
        $closure = function () use ($name) {
            return $this->$name;
        };

        return $closure->call($object);
    }
}

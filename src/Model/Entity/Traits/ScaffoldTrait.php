<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity\Traits;

use JeremyHarris\LazyLoad\ORM\LazyLoadEntityTrait;
use OurSociety\Model\Table\AppTable;
use OurSociety\View\Scaffold;

trait ScaffoldTrait
{
    use LazyLoadEntityTrait;

    public function getModel(): AppTable
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->_repository();
    }

    public function getScaffoldDisplayField(): string
    {
        return $this->getModel()->getDisplayField();
    }

    public function getScaffoldFieldList(): Scaffold\FieldList
    {
        return Scaffold\FieldList::fromArray($this->getModel(), $this->getModel()->getSchema()->columns());
    }
}

<?php
declare(strict_types=1);

namespace OurSociety\View\Tag\Action\Index;

use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Entity;
use OurSociety\Model\Entity\Traits\TagAware;
use OurSociety\View\Scaffold\FieldList;
use OurSociety\View\Tag\Tag;

class Table extends Tag
{
    /**
     * @var ResultSetInterface
     */
    private $resultSet;

    /**
     * @var FieldList
     */
    private $fieldList;

    public function __construct(ResultSetInterface $resultSet, FieldList $fieldList)
    {
        $this->resultSet = $resultSet;
        $this->fieldList = $fieldList;
    }

    /**
     * @return ResultSetInterface
     */
    public function getResultSet(): ResultSetInterface
    {
        return $this->resultSet;
    }

    public function getHeading(): string
    {
        return $this->getEntity()->getSource();
    }

    public function getFieldList(): FieldList
    {
        return $this->fieldList ?? $this->getEntity()->getDefaultFieldList();
    }

    public function hasActions(): bool
    {
        return false;
    }

    /**
     * @return TagAware|Entity
     */
    private function getEntity(): Entity
    {
        return $this->getResultSet()->first();
    }
}

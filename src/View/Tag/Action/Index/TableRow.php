<?php
declare(strict_types=1);

namespace OurSociety\View\Tag\Action\Index;

use Cake\ORM\Entity;
use OurSociety\View\Scaffold\FieldList;
use OurSociety\View\Tag\Tag;

class TableRow extends Tag
{
    /**
     * @var TableBody
     */
    private $tableBody;

    /**
     * @var Entity
     */
    private $entity;

    public function __construct(TableBody $tableBody, Entity $entity)
    {
        $this->tableBody = $tableBody;
        $this->entity = $entity;
    }

    public function hasActions(): bool
    {
        return $this->tableBody->hasActions();
    }

    public function getFieldList(): FieldList
    {
        return $this->tableBody->getFieldList();
    }

    public function getEntity(): Entity
    {
        return $this->entity;
    }
}

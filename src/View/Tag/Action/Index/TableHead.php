<?php
declare(strict_types=1);

namespace OurSociety\View\Tag\Action\Index;

use OurSociety\View\Scaffold\FieldList;
use OurSociety\View\Tag\Tag;

class TableHead extends Tag
{
    /**
     * @var Table
     */
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getFieldList(): FieldList
    {
        return $this->table->getFieldList();
    }

    public function hasActions(): bool
    {
        return $this->table->hasActions();
    }
}
